import { mapActions } from 'vuex'

const scheduleReportMixin = {
  mixins: [],
  data() {
    return {
      data: null,
      scheduleDays: [],
    }
  },
  methods: {
    ...mapActions({
      showData: 'scheduleReport/fetchDetailScheduleReport',
      fetchDays: 'scheduleDay/fetchScheduleDay',
    }),
  },
  mounted() {
    this.showData({ id: this.$route.params.id }).then((result) => {
      this.data = result.data.data
    })

    this.fetchDays().then((result) => {
      this.scheduleDays = result.data.data
    })
  },
}

export default scheduleReportMixin
