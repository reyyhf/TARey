const indexMixins = {
  data() {
    return {
      width: '500',
      isLoading: false,
      withButtonAction: true,
      showModal: false,
      dataId: null,
      dialog: false,
      buttonAction: {
        action: this.openModal,
        text: 'Tambah',
        icon: 'plus',
      },
      updateOrCreateTitle: 'Tambah',
      results: [],
      timeoutValue: 1000,
      viewModal: false,
    }
  },
  async mounted() {
    await this.loadData()
  },

  methods: {
    async loadData() {
      this.isLoading = true

      await this.fetchData(this.params)
        .then((result) => {
          this.results = result.data.data
        })
        .catch((err) => {
          console.error(err)
        })
        .finally(() => {
          this.isLoading = false
        })
    },

    async view(id) {
      this.showModal = true
      this.dataId = id
      this.updateOrCreateTitle = 'Ubah'
      await this.showData({ id: id }).then((response) => {
        let result = response.data.data
        this.payload = result
      })
    },

    async viewData(id) {
      this.viewModal = true
      this.dataId = id
      this.showData({ id: id }).then((response) => {
        let result = response.data.data
        this.payload = result
      })
    },

    async destroy() {
      this.destroyData({ id: this.dataId })
        .then((response) => {
          let result = response.data.meta

          this?.$refs?.alert?.show(result.status, result.message)

          setTimeout(() => {
            this.loadData()
            this.closeModal()
          }, this.timeoutValue)
        })
        .catch((error) => {
          let result = error.response.data.meta

          this?.$refs?.alert?.show(result.status, result.message)
        })
        .finally(() => {
          this.dialog = false
        })
    },

    async storeDataHandler(payload) {
      await this.storeData(payload)
        .then((response) => {
          let result = response.data.meta

          this?.$refs?.alert?.show(result.status, result.message)

          setTimeout(() => {
            this.loadData()
            this.closeModal()
          }, this.timeoutValue)
        })
        .catch((error) => {
          let result = error.response.data.meta
          this?.$refs?.alert?.show(result.status, result.message)
        })
    },

    async updateDataHandler(payload) {
      await this.updateData(payload)
        .then((response) => {
          let result = response.data.meta

          this?.$refs?.alert?.show(result.status, result.message)

          setTimeout(() => {
            this.loadData()
            this.closeModal()
          }, this.timeoutValue)
        })
        .catch((error) => {
          let result = error.response.data.meta

          this?.$refs?.alert?.show(result.status, result.message)
        })
    },

    async submit() {
      let payload = this.payload

      if (this.dataId) {
        let updatePayload = Object.assign(payload, { id: this.dataId })
        await this.updateDataHandler(updatePayload)
      } else {
        await this.storeDataHandler(payload)
      }
    },

    closeModal() {
      this.resetForm()
      this.showModal = false
      this.dataId = null
    },

    closeViewModal() {
      this.viewModal = false
      this.payload = {}
      this.dataId = null
    },

    openModal() {
      this.updateOrCreateTitle = 'Tambah'
      this.showModal = true
    },

    showDestroyModal(id) {
      this.dataId = id
      this.dialog = true
    },

    resetForm() {
      this.payload = {}
      this.$refs.form.$refs.observer.reset()
    },
  },
}

export default indexMixins
