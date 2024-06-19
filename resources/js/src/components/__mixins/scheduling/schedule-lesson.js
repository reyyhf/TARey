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
      classrooms: [],
      curriculum_types: [
        { id: 'X IPA', name: 'X IPA' },
        { id: 'XI IPA', name: 'XI IPA' },
        { id: 'XII IPA', name: 'XII IPA' },
        { id: 'X IPS', name: 'X IPS' },
        { id: 'XI IPS', name: 'XI IPS' },
        { id: 'XII IPS', name: 'XII IPS' },
      ],
      payload: {
        classroom_id: null,
        curiculum_type: null,
      },
    }
  },
  async created() {
    this.isLoading = true

    await this.fetchClassroomsData()
      .then((result) => {
        this.classrooms = result.data.data
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
      fetchData: 'scheduleLesson/fetchScheduleLessons',
      storeData: 'scheduleLesson/storeScheduleLesson',
      showData: 'scheduleLesson/fetchDetailScheduleLesson',
      updateData: 'scheduleLesson/updateScheduleLesson',
      destroyData: 'scheduleLesson/destroyScheduleLesson',
      fetchClassroomsData: 'classroom/fetchClassroom',
    }),
  },
}

export default scheduleLessonMixin
