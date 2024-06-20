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
      payload: {},
    }
  },
  async created() {},
  methods: {
    ...mapActions({
      fetchData: 'scheduleLessonItem/fetchScheduleLessonItems',
    }),
  },
}

export default scheduleLessonItemMixin
