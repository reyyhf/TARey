import { mapActions } from 'vuex'
import indexMixins from '@Components/__mixins/base/index'

const scheduleLessonMixin = {
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
          text: 'Tahun Ajaran',
          value: 'semester_year',
          sortable: true,
        },
        {
          text: 'Kelas',
          value: 'classroom.name',
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

  methods: {
    ...mapActions({
      fetchData: 'scheduleLesson/fetchScheduleLessons',
    }),
  },
}

export default scheduleLessonMixin
