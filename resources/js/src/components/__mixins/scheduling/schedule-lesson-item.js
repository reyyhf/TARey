import { mapActions } from 'vuex'
import indexMixins from '@Components/__mixins/base/index'

const scheduleLessonItemMixin = {
  mixins: [indexMixins],
  data() {
    return {
      headers: [
        {
          text: 'No.',
          value: 'number',
          sortable: true,
        },
        {
          text: 'Hari',
          value: 'schedule_lesson_hour.schedule_day.name',
          sortable: true,
        },
        {
          text: 'Pelajaran',
          value: 'lesson.name',
          sortable: true,
        },
        {
          text: 'Pengajar',
          value: 'teacher.name',
          sortable: true,
        },
        {
          text: 'Pengajar',
          value: 'schedule_lesson_hour',
          sortable: true,
        },
        {
          text: 'Aksi',
          value: 'actions',
          align: 'center',
          sortable: false,
        },
      ],
      scheduleLesson: null,
      curriculums: [],
      lessons: [],
      teachers: [],
      days: [],
      hours: [],
      criteriaConstraints: [],
      hourFields: [],
      payload: {
        lesson_id: null,
        teacher_id: null,
        schedule_lesson_id: this.$route.params.id,
        schedule_day_id: null,
      },
      params: {
        schedule_lesson_id: this.$route.params.id,
      },
    }
  },
  computed: {
    _fields() {
      if (!this.payload.lesson_id) return []

      const lesson = this.lessons.find(
        (lesson) => lesson.id === this.payload.lesson_id
      )
      if (!lesson || !this.scheduleLesson) return []

      const maxHour = this.curriculums.reduce((acc, curriculum) => {
        if (curriculum.lesson_id === lesson.id) {
          const curricular = curriculum.curricular.find(
            (curricular) =>
              curricular.classroom_label === this.scheduleLesson.curriculum_type
          )
          if (!curricular) return acc
          return acc + curricular.maximum_hours_per_week
        }
        return acc
      }, 0)
      const usedHour = this.results.reduce(
        (acc, lessonItem) =>
          lessonItem.lesson_id === lesson.id ? acc + 1 : acc,
        0
      )
      const remainingHour = Math.max(0, maxHour - usedHour)

      return Array.from(Array(remainingHour)).map((_, index) => ({
        showDay: (index + 1) % 2 === 1,
      }))
    },
  },
  watch: {
    _fields: function (fields) {
      this.hourFields = fields.map((field) => ({
        ...field,
        selectedDayId: null,
        selectedHourId: null,
      }))
    },
    'payload.schedule_lesson_id': async function () {
      if (!this.payload.schedule_lesson_id) {
        this.payload.schedule_lesson_id = this.$route.params.id
      }
    },
    'payload.lesson_id': async function () {
      this.teachers = []

      await this.fetchTeachers()
        .then((result) => {
          this.teachers = result.data.data.filter((teacher) =>
            teacher.teacher_lessons.includes(this.payload.lesson_id)
          )
        })
        .catch((err) => {
          console.error(err)
        })
        .finally(() => {
          this.isLoading = false
        })
    },
    'payload.schedule_day_id': async function () {
      this.hours = []

      await this.fetchLessonHours({
        schedule_day_id: this.payload.schedule_day_id,
      })
        .then((result) => {
          this.hours = result.data.data
        })
        .catch((err) => {
          console.error(err)
        })
        .finally(() => {
          this.isLoading = false
        })
    },
  },
  created() {
    this.fetchLessons()
      .then((result) => {
        this.lessons = result.data.data
      })
      .catch((err) => {
        console.error(err)
      })

    this.fetchScheduleDays()
      .then((result) => {
        this.days = result.data.data
      })
      .catch((err) => {
        console.error(err)
      })

    this.isLoading = true
    this.fetchScheduleLesson({ id: this.$route.params.id })
      .then((scheduleLesson) => {
        this.scheduleLesson = scheduleLesson.data.data

        this.fetchCurriculums()
          .then((curriculums) => {
            this.curriculums = curriculums.data.data.filter((curriculum) => {
              return curriculum.curricular.some(
                (curricular) =>
                  curricular.classroom_label ===
                  this.scheduleLesson.curriculum_type
              )
            })
          })
          .catch((err) => {
            console.error(err)
          })
      })
      .catch((err) => {
        alert(err?.message || 'data Tidak ditemukan')
      })
      .finally(() => {
        this.isLoading = false
      })
  },
  methods: {
    ...mapActions({
      storeData: 'scheduleLessonItem/storeScheduleLessonItem',
      showData: 'scheduleLessonItem/fetchDetailScheduleLessonItem',
      fetchData: 'scheduleLessonItem/fetchScheduleLessonItems',
      fetchLessons: 'lesson/fetchLesson',
      fetchTeachers: 'teacher/fetchTeacher',
      fetchScheduleDays: 'scheduleDay/fetchScheduleDay',
      fetchLessonHours: 'scheduleLessonHour/fetchScheduleLessonHour',
      updateData: 'scheduleLessonItem/updateScheduleLessonItem',
      destroyData: 'scheduleLessonItem/destroyScheduleLessonItem',
      fetchScheduleLesson: 'scheduleLesson/fetchDetailScheduleLesson',
      fetchCurriculums: 'curriculum/fetchCurriculum',
      fetchCriteriaConstraints: 'criteriaConstraint/fetchCriteriaConstraint',
    }),
  },
}

export default scheduleLessonItemMixin
