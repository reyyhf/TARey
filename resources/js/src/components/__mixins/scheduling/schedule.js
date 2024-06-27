import { mapActions } from 'vuex'

const scheduleReportMixin = {
  mixins: [],
  data() {
    return {
      isLoading: false,
      tabuSearchResult: null,
    }
  },
  methods: {
    ...mapActions({
      fetchTabuSearch: 'tabuSearch/fetchTabuSearch',
    }),
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
