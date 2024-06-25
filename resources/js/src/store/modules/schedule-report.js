import { apiHandler } from '@/plugins/api-handler'

const scheduleReportApiUrl = 'schedule-report'

const scheduleReport = {
  namespaced: true,
  state: () => ({
    scheduleReports: [],
    scheduleReport: [],
    error: null,
  }),
  getters: {
    getScheduleReports(state) {
      return state.scheduleReports
    },
  },
  mutations: {
    setScheduleReports(state, data) {
      state.scheduleReports = data
    },
  },
  actions: {
    fetchScheduleReports(context, parameter) {
      return new Promise((resolve, reject) => {
        apiHandler
          .get(`${scheduleReportApiUrl}`, { params: parameter })
          .then((response) => {
            console.log(response.data)
            context.commit('setScheduleReports', response.data.data)
            resolve(response)
          })
          .catch((errors) => {
            reject(errors)
          })
      })
    },
    storeScheduleReport(_context, parameter) {
      return new Promise((resolve, reject) => {
        apiHandler
          .post(`${scheduleReportApiUrl}/store`, parameter)
          .then((response) => {
            resolve(response)
          })
          .catch((errors) => {
            reject(errors)
          })
      })
    },
    fetchDetailScheduleReport(context, parameter) {
      return new Promise((resolve, reject) => {
        apiHandler
          .get(`${scheduleReportApiUrl}/${parameter.id}`)
          .then((response) => {
            context.commit('setScheduleReport', response.data.data)
            resolve(response)
          })
          .catch((errors) => {
            reject(errors)
          })
      })
    },
    updateScheduleReport(_context, parameter) {
      return new Promise((resolve, reject) => {
        apiHandler
          .put(`${scheduleReportApiUrl}/update/${parameter.id}`, parameter)
          .then((response) => {
            resolve(response)
          })
          .catch((errors) => {
            reject(errors)
          })
      })
    },
    destroyScheduleReport(_context, parameter) {
      return new Promise((resolve, reject) => {
        apiHandler
          .delete(`${scheduleReportApiUrl}/destroy/${parameter.id}`)
          .then((response) => {
            resolve(response)
          })
          .catch((errors) => {
            reject(errors)
          })
      })
    },
  },
}

export default scheduleReport
