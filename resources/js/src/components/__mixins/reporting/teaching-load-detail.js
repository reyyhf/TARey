import { mapActions } from 'vuex'

const scheduleReportMixin = {
  mixins: [],
  data() {
    return {
      data: null,
      teachers: [],
      teacherId: null
    }
  },
  methods: {
    ...mapActions({
      showData: 'scheduleReport/fetchDetailScheduleReport',
      fetchDays: 'scheduleDay/fetchScheduleDay',
      fetchTeachers: 'teacher/fetchTeacher',
    }),
  },
  computed: {
    maxTotalHours() {
      if (!this.data) return 0
      const total_hours =
        this.data.data_teaching_weight[0].classrooms[0].schedules.reduce(
          (acc, schedule) => {
            return schedule.total_hours > acc ? schedule.total_hours : acc
          },
          0
        )
      return total_hours
    },
    days() {
      if (!this.data) return []

      return this.data.data_teaching_weight[0].classrooms[0].schedules || []
    },
  },
  mounted() {
    this.showData({ id: this.$route.params.id }).then((result) => {
      this.data = result.data.data
    })

    this.fetchTeachers().then((result) => {
      this.teachers = result.data.data
    })
  },
}

export default scheduleReportMixin
