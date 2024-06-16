<?php

namespace App\Http\Services\MasterData;

use App\Exceptions\ErrorAPIException;
use App\Helpers\ApiResponseTrait;
use App\Http\Repositories\MasterData\CurriculumLessonRepository;
use App\Http\Repositories\MasterData\LessonRepository;
use App\Http\Repositories\MasterData\SemesterRepository;
use App\Http\Resources\MasterData\CurriculumLessonResource;
use Illuminate\Support\Facades\DB;

class CurriculumLessonService
{
    use ApiResponseTrait;

    private $repository;

    private $lessonRepository;

    private $semesterRepository;

    public function __construct(
        CurriculumLessonRepository $repository,
        LessonRepository $lessonRepository,
        SemesterRepository $semesterRepository
    ) {
        $this->repository = $repository;
        $this->lessonRepository = $lessonRepository;
        $this->semesterRepository = $semesterRepository;
    }

    private function mappedData($data)
    {
        return $data->map(function ($curriculum) {
            $lessonName = $curriculum->first()->lessons->pluck('name')->toArray();

            return [
                'id' => $curriculum->first()->lesson_id,
                'lesson_id' => $curriculum->first()->lesson_id,
                'lesson_name' => implode($lessonName),
                'curricular' => $curriculum->map(function ($curriculum) {
                    return [
                        'id' => $curriculum->id,
                        'classroom_label' => $curriculum->classroom_label,
                        'maximum_hours_per_week' => $curriculum->maximum_hours_per_week,
                    ];
                }),
            ];
        });
    }

    public function index()
    {
        $curriculumLessons = $this->repository->index();

        $curriculumLessons = $this->mappedData($curriculumLessons);

        $response = collect($curriculumLessons)->values();

        return $this->resultResponse('success', 'Data Berhasil Ditampilkan', 200, $response);
    }

    public function store($inputData)
    {
        return DB::transaction(function () use ($inputData) {
            $lesson = $this->lessonRepository->find($inputData['lesson_id']);

            $activeSemester = $this->semesterRepository->findColumn('is_active', true);

            if (! $lesson) {
                DB::rollBack();
                throw new ErrorAPIException('Mata Pelajaran Tidak Ditemukan', 400);
            }

            foreach ($inputData['curricular'] as $curricular) {
                $curricular['lesson_id'] = $inputData['lesson_id'];
                $curricular['semester_id'] = $activeSemester->id;

                $storeCurriculum = $this->repository->store($curricular);

                if (! $storeCurriculum) {
                    DB::rollBack();
                    throw new ErrorAPIException('Data Gagal Ditambah', 400);
                }
            }

            $result = new CurriculumLessonResource($lesson);

            return $this->resultResponse('success', 'Data Berhasil Ditambahkan', 201, $result);
        });
    }

    public function show($id)
    {
        $curriculumLesson = $this->repository->find($id);

        $curriculumLesson = $this->mappedData($curriculumLesson);

        $response = collect($curriculumLesson)->values();

        return $this->resultResponse('success', 'Data Berhasil Ditampilkan', 200, $response);
    }

    public function update($id, $inputData)
    {
        return DB::transaction(function () use ($inputData) {
            $lesson = $this->lessonRepository->find($inputData['lesson_id']);

            $activeSemester = $this->semesterRepository->findColumn('is_active', true);

            if (! $lesson) {
                DB::rollBack();
                throw new ErrorAPIException('Mata Pelajaran Tidak Ditemukan', 400);
            }

            if (isset($inputData['removed_data'])) {
                foreach ($inputData['removed_data'] as $removed) {
                    $removedCurricular = $this->repository->findColumn(
                        'classroom_label',
                        $removed['classroom_label']
                    );

                    if ($removedCurricular) {
                        $destroyCurriculum = $removedCurricular->delete();

                        if (! $destroyCurriculum) {
                            DB::rollBack();
                            throw new ErrorAPIException('Data Gagal Diubah', 400);
                        }
                    }
                }
            }

            foreach ($inputData['curricular'] as $curricular) {

                $curricular['lesson_id'] = $inputData['lesson_id'];
                $curricular['semester_id'] = $activeSemester->id;

                $payloads = [
                    'id' => $curricular['id'] ?? null,
                    'lesson_id' => $inputData['lesson_id'],
                ];

                $updateCurriculum = $this->repository->checkUpdateOrCreate($payloads, $curricular);

                if (! $updateCurriculum) {
                    DB::rollBack();
                    throw new ErrorAPIException('Data Gagal Diubah', 400);
                }
            }

            $result = new CurriculumLessonResource($lesson);

            return $this->resultResponse('success', 'Data Berhasil Diubah', 200, $result);
        });
    }

    public function destroy($id)
    {
        return DB::transaction(function () use ($id) {
            $curriculumLesson = $this->repository->destroy($id);

            if (! $curriculumLesson) {
                DB::rollBack();
                throw new ErrorAPIException('Data Gagal Dihapus', 500);
            }

            return $this->resultResponse('success', 'Data Berhasil Dihapus', 200);
        });
    }
}
