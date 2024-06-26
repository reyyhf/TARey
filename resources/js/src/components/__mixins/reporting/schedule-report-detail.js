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
      showData: 'scheduleReport/fetchDetailScheduleReport',
    }),
  },
  mounted() {
    this.showData({ id: this.$route.params.id }).then((result) => {
      this.data = result.data.data
      console.log(this.data)
    })
  },
}

export default scheduleReportMixin
