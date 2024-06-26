<?php

namespace App\Http\Services\Scheduling;

use App\Exceptions\ErrorAPIException;
use App\Helpers\ApiResponseTrait;
use App\Http\Repositories\MasterData\SemesterRepository;
use App\Http\Repositories\Scheduling\ScheduleLessonRepository;
use App\Models\MasterData\ScheduleDay;
use App\Models\MasterData\ScheduleLessonHour;
use App\Models\Scheduling\CriteriaConstraint;
use App\Models\Scheduling\ScheduleLesson;
use App\Models\Scheduling\ScheduleLessonItem;
use Illuminate\Support\Facades\Log;

class TabuSearchService
{
    use ApiResponseTrait;

    private ScheduleLessonRepository $scheduleLessonRepository;
    private SemesterRepository $semesterRepository;

    public function __construct(ScheduleLessonRepository $scheduleLessonRepository, SemesterRepository $semesterRepository)
    {
        $this->scheduleLessonRepository = $scheduleLessonRepository;
        $this->semesterRepository = $semesterRepository;
    }

    public function search($inputData)
    {
        $maxIteration = isset($inputData['max_iteration']) ? intval($inputData['max_iteration']) : 100;
        $tabuSize = isset($inputData['tabu_size']) ? intval($inputData['tabu_size']) : 10;

        $scheduleDays = ScheduleDay::orderBy('order_direction', 'asc')->get()->toArray();
        $scheduleClassrooms = $this->initSolutions($scheduleDays);
        $scheduleClassrooms = $this->evaluateSchedules($scheduleClassrooms);

        $result = $this->tabuSearch($scheduleClassrooms, $tabuSize, $maxIteration);
        $result['result'] = $this->fillLessonsWithHour($result['result']);

        return $this->resultResponse('success', 'Data berhasil ditampilkan', 200, $result);
    }

    public function initSolutions($scheduleDays)
    {
        $scheduleClassrooms = ScheduleLesson::with('classroom')->get()->toArray();

        foreach ($scheduleClassrooms as &$scheduleClassroom) {

            // Initialize an empty array for schedules
            $schedules = [];

            foreach ($scheduleDays as $scheduleDay) {
                // Initialize an empty array for lessons
                $lessons = [];
                for ($i = 1; $i <= $scheduleDay['total_hours']; $i++) {
                    $lesson = ScheduleLessonItem::with('lesson', 'teacher')->whereHas('scheduleLessonHour', function ($query) use ($i, $scheduleDay, $scheduleClassroom) {
                        $query->whereHas('scheduleDay', function ($query) use ($scheduleDay) {
                            $query->where('id', $scheduleDay['id']);
                        })->where('started_at', $i)->where('schedule_lesson_id', $scheduleClassroom['id']);
                    })->first();

                    unset($lesson['schedule_lesson_hour_id']);

                    $lessons[] = $lesson;
                }
                // Set the lessons array to the scheduleDay
                $scheduleDay['lessons'] = $lessons;
                // Add the scheduleDay to the schedules array
                $schedules[] = $scheduleDay;
            }

            // Set the schedules array to the scheduleClassroom
            $scheduleClassroom['schedules'] = $schedules;
        }

        return $scheduleClassrooms;
    }

    public function generateNewSolution($scheduleClassrooms)
    {
        $scheduleClassrooms = $this->deepClone($scheduleClassrooms);

        foreach ($scheduleClassrooms as &$scheduleClassroom) {
            $scheduleLessonItems = [];

            foreach ($scheduleClassroom['schedules'] as &$day) {
                foreach ($day['lessons'] as &$lesson) {
                    if ($lesson) {
                        $lesson['score'] = 0;
                        $lesson['errors'] = [];
                        $scheduleLessonItems[] = $lesson;
                    }
                }
            }

            shuffle($scheduleLessonItems);

            foreach ($scheduleClassroom['schedules'] as &$day) {
                foreach ($day['lessons'] as $index => &$lesson) {
                    if ($lesson) {
                        $day['lessons'][$index] = array_pop($scheduleLessonItems);
                    }
                }
            }
        }

        return $scheduleClassrooms;
    }

    public function evaluateSchedules($scheduleClassrooms)
    {
        $constraint = CriteriaConstraint::where('is_dynamic', true)->first();

        $maxTeachingHours = $constraint->max_teaching_hours;
        $maxSubjectHours = $constraint->max_subject_hours;

        // Check constraint
        foreach ($scheduleClassrooms as $scheduleClassroom) {
            foreach ($scheduleClassroom['schedules'] as $day) {
                foreach ($day['lessons'] as $index => $lesson) {
                    if (!$lesson)
                        continue;

                    $conflict = $this->checkTeacherHourConflict($scheduleClassrooms, $lesson['teacher']['id'], $index, $day['name']);
                    if ($conflict) {
                        if (isset($lesson['score'])) {
                            $lesson['score'] += 20;
                        } else {
                            $lesson['score'] = 20;
                        }

                        if (!isset($lesson['errors'])) {
                            $lesson['errors'] = ['Terdapat jam yang bentrok'];
                        } else {
                            $lesson['errors'] = array_merge($lesson['errors'], ['Terdapat jam yang bentrok']);
                        }
                    } else {
                        $lesson['score'] = 0;
                        $lesson['errors'] = [];
                    }

                    $violations = $this->checkTeachingHours($scheduleClassrooms, $maxTeachingHours);
                    if (!empty($violations)) {
                        foreach ($violations as $violation) {
                            if ($scheduleClassroom['classroom']['id'] == $violation['classroom_id']) {
                                if ($day['id'] == $violation['schedule_id']) {
                                    $lesson = &$day['lessons'][$violation['lesson_index']];
                                    if (isset($lesson['score'])) {
                                        $lesson['score'] += 20; // or any value you want to penalize
                                    } else {
                                        $lesson['score'] = 20; // or any value you want to penalize
                                    }

                                    if (!isset($lesson['errors'])) {
                                        $lesson['errors'] = ["Jam mengajar melebihi $maxTeachingHours jam"];
                                    } else {
                                        $lesson['errors'] = array_merge($lesson['errors'], ["Jam mengajar melebihi $maxTeachingHours jam"]);
                                    }
                                }
                            }
                        }
                    }

                    $this->checkConsecutiveSubjectHours($scheduleClassrooms, $maxSubjectHours);
                }
            }
        }

        return $scheduleClassrooms;
    }

    function checkTeacherHourConflict($scheduleClassrooms, $teacherId, $hour, $dayName)
    {
        $count = 0;
        foreach ($scheduleClassrooms as $scheduleClassroom) {
            foreach ($scheduleClassroom['schedules'] as $day) {
                foreach ($day['lessons'] as $index => $lesson) {
                    if ($lesson && $index == $hour && $lesson['teacher_id'] == $teacherId && $day['name'] == $dayName) {
                        $count += 1;
                    }
                }
            }
        }
        return $count > 1;
    }

    public function checkTeachingHours($scheduleClassrooms, $maxTeachingHours)
    {
        $violations = [];
        foreach ($scheduleClassrooms as $classroom) {
            foreach ($classroom['schedules'] as $schedule) {
                $dailyTeaching = [];

                foreach ($schedule['lessons'] as $index => $lesson) {
                    if ($lesson !== null) {
                        $teacherId = $lesson['teacher']['id'];
                        $lessonId = $lesson['lesson']['id'];

                        if (!isset($dailyTeaching[$teacherId])) {
                            $dailyTeaching[$teacherId] = [];
                        }

                        if (!isset($dailyTeaching[$teacherId][$lessonId])) {
                            $dailyTeaching[$teacherId][$lessonId] = 0;
                        }

                        $dailyTeaching[$teacherId][$lessonId]++;

                        if ($dailyTeaching[$teacherId][$lessonId] > $maxTeachingHours) {
                            $violations[] = [
                                'classroom_id' => $classroom['classroom']['id'],
                                'schedule_id' => $schedule['id'],
                                'lesson_index' => $index,
                                'hours' => $dailyTeaching[$teacherId][$lessonId],
                                'max_hours' => $maxTeachingHours
                            ];
                        }
                    }
                }
            }
        }


        return $violations;
    }

    public function checkConsecutiveSubjectHours(&$scheduleClassrooms, $maxSubjectHours)
    {
        foreach ($scheduleClassrooms as &$classroom) {
            foreach ($classroom['schedules'] as &$schedule) {
                $dailyLessons = [];

                foreach ($schedule['lessons'] as $index => &$lesson) {
                    if ($lesson !== null) {
                        $subjectId = $lesson['lesson']['id'];

                        if (!isset($dailyLessons[$subjectId])) {
                            $dailyLessons[$subjectId] = 0;
                        }

                        $dailyLessons[$subjectId]++;

                        // Check if the subject exceeds maxConsecutiveHours
                        if ($dailyLessons[$subjectId] > $maxSubjectHours) {
                            if (isset($lesson['score'])) {
                                $lesson['score'] += 20; // Penalty value
                            } else {
                                $lesson['score'] = 20; // Penalty value
                            }

                            if (!isset($lesson['errors'])) {
                                $lesson['errors'] = ["Jam maksimal mata pelajaran berurutan melebihi $maxSubjectHours jam"];
                            } else {
                                $lesson['errors'] = array_merge($lesson['errors'], ["Jam maksimal mata pelajaran berurutan melebihi $maxSubjectHours jam"]);
                            }
                        }
                    } else {
                        // Reset the counter if there is a break in the sequence
                        $dailyLessons = [];
                    }
                }
            }
        }
    }

    public function sumTotalScore($scheduleClassrooms)
    {
        $totalScore = 0;
        foreach ($scheduleClassrooms as $scheduleClassroom) {
            foreach ($scheduleClassroom['schedules'] as $day) {
                foreach ($day['lessons'] as $lesson) {
                    if ($lesson) {
                        $totalScore += $lesson['score'];
                    }
                }
            }
        }

        return $totalScore;
    }

    private function tabuSearch($initSchedule, $tabuSize, $maxIteration)
    {
        $currentSolution = $this->deepClone($initSchedule);
        $bestSolution = $this->deepClone($initSchedule);
        $bestScore = $this->sumTotalScore($bestSolution);
        $tabuList = [];

        for ($iteration = 0; $iteration < $maxIteration; $iteration++) {
            $newSolution = $this->generateNewSolution($currentSolution);

            $newEvaluateSchedule = $this->evaluateSchedules($newSolution);


            $newScore = $this->sumTotalScore($newEvaluateSchedule);
            if ($newScore < $bestScore) {
                $bestSolution = $this->deepClone($newSolution);
                $bestScore = $newScore;
            }

            if (!in_array($newSolution, $tabuList)) {
                $tabuList[] = $this->deepClone($newSolution);

                if (count($tabuList) > $tabuSize) {
                    array_shift($tabuList);
                }

                $currentSolution = $this->deepClone($newSolution);
            }
        }

        return [
            'result' => $bestSolution,
            'score' => $bestScore,
        ];
    }


    public function fillLessonsWithHour($scheduleClassrooms)
    {
        foreach ($scheduleClassrooms as &$scheduleClassroom) {
            foreach ($scheduleClassroom['schedules'] as &$day) {
                foreach ($day['lessons'] as $index => &$lesson) {
                    if ($lesson) {
                        $lesson['hour'] = ScheduleLessonHour::where('schedule_day_id', $day['id'])->where('started_at', $index + 1)->first();
                    }
                }
            }
        }

        return $scheduleClassrooms;
    }

    public function deepClone($array)
    {
        return unserialize(serialize($array));
    }
}
