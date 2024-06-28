import { mapActions } from 'vuex'

const scheduleReportMixin = {
  mixins: [],
  data() {
    return {
      isLoading: false,
      tabuSearchResult: null,
      showModal: false,
      payload: {
        data: null,
        title: 'Tahun Ajaran 2024/2025',
      },
    }
  },
  methods: {
    ...mapActions({
      fetchTabuSearch: 'tabuSearch/fetchTabuSearch',
      storeScheduleReport: 'scheduleReport/storeScheduleReport',
    }),
    submit() {
      this.isLoading = true
      this.storeScheduleReport({
        title: this.payload.title,
        data: JSON.stringify(this.tabuSearchResult),
      })
        .then((result) => {
          this.$router.push({ name: 'schedule-report' })
          this?.$refs?.alert?.show(
            result?.data?.meta?.status,
            result?.data?.meta?.message
          )
        })
        .catch((err) => {
          this?.$refs?.alert?.show('error', err?.message)
          console.log(err)
        })
        .finally(() => {
          this.isLoading = false
        })
    },
  },
  mounted() {
    this.isLoading = true
    this.fetchTabuSearch({ tabuSize: 1, maxIteration: 0 })
      .then((result) => {
        this?.$refs?.alert?.show(
          result?.data?.meta?.status,
          result?.data?.meta?.message
        )
        this.tabuSearchResult = result.data.data
        this.payload.data = result.data.data
      })
      .catch((err) => {
        this?.$refs?.alert?.show('error', err?.message)
        console.log(err)
      })
      .finally(() => {
        this.isLoading = false
      })
  },
}

export default scheduleReportMixin
