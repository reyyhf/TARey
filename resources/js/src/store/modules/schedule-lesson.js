import { apiHandler } from '@/plugins/api-handler'

const scheduleLessonApiUrl = 'schedule-lesson'

const scheduleLesson = {
  namespaced: true,
  state: () => ({
    scheduleLessons: [],
    scheduleLesson: [],
    error: null,
  }),
  getters: {
    getScheduleLessons(state) {
      return state.scheduleLessons
    },
  },
  mutations: {
    setScheduleLessons(state, data) {
      state.scheduleLessons = data
    },
  },
  actions: {
    fetchScheduleLessons(context, parameter) {
      return new Promise((resolve, reject) => {
        apiHandler
          .get(`${scheduleLessonApiUrl}`, { params: parameter })
          .then((response) => {
            context.commit('setScheduleLessons', response.data.data)
            resolve(response)
          })
          .catch((errors) => {
            reject(errors)
          })
      })
    },
    storeScheduleLesson(_context, parameter) {
      return new Promise((resolve, reject) => {
        apiHandler
          .post(`${scheduleLessonApiUrl}/store`, parameter)
          .then((response) => {
            resolve(response)
          })
          .catch((errors) => {
            reject(errors)
          })
      })
    },
    fetchDetailScheduleLesson(context, parameter) {
      return new Promise((resolve, reject) => {
        apiHandler
          .get(`${scheduleLessonApiUrl}/${parameter.id}`)
          .then((response) => {
            context.commit('setScheduleLesson', response.data.data)
            resolve(response)
          })
          .catch((errors) => {
            reject(errors)
          })
      })
    },
    updateScheduleLesson(_context, parameter) {
      return new Promise((resolve, reject) => {
        apiHandler
          .put(`${scheduleLessonApiUrl}/update/${parameter.id}`, parameter)
          .then((response) => {
            resolve(response)
          })
          .catch((errors) => {
            reject(errors)
          })
      })
    },
    destroyScheduleLesson(_context, parameter) {
      return new Promise((resolve, reject) => {
        apiHandler
          .delete(`${scheduleLessonApiUrl}/destroy/${parameter.id}`)
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

export default scheduleLesson
