import { mapActions } from 'vuex'

const scheduleReportMixin = {
  mixins: [],
  data() {
    return {
      data: null,
    }
  },
  methods: {
    ...mapActions({
      showReportDashboard: 'scheduleReport/fetchScheduleReportDashboard',
    }),
  },
  mounted() {
    this.showReportDashboard().then((result) => {
      this.data = result.data.data
    })
  },
}

export default scheduleReportMixin
