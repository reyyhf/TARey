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
      lessons: [],
      teachers: [],
      days: [],
      hours: [],
      payload: {
        lesson_id: null,
        teacher_id: null,
        schedule_lesson_id: this.$route.params.id,
        schedule_day_id: null,
        schedule_lesson_hour_id: null,
      },
    }
  },
  watch: {
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
      .finally(() => {
        this.isLoading = false
      })

    this.fetchScheduleDays()
      .then((result) => {
        this.days = result.data.data
      })
      .catch((err) => {
        console.error(err)
      })
      .finally(() => {
        this.isLoading = false
      })
  },
  methods: {
    ...mapActions({
      storeData: 'scheduleLessonItem/storeScheduleLessonItem',
      fetchData: 'scheduleLessonItem/fetchScheduleLessonItems',
      fetchLessons: 'lesson/fetchLesson',
      fetchTeachers: 'teacher/fetchTeacher',
      fetchScheduleDays: 'scheduleDay/fetchScheduleDay',
      fetchLessonHours: 'scheduleLessonHour/fetchScheduleLessonHour',
    }),
  },
}

export default scheduleLessonItemMixin
