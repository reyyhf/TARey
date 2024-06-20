import { apiHandler } from '@/plugins/api-handler'

const scheduleLessonItemApiUrl = 'schedule-lesson-item'

const scheduleLessonItem = {
  namespaced: true,
  state: () => ({
    scheduleLessonItems: [],
    error: null,
  }),
  getters: {
    getScheduleLessonItems(state) {
      return state.scheduleLessonItems
    },
  },
  mutations: {
    setScheduleLessonItems(state, data) {
      state.scheduleLessonItems = data
    },
  },
  actions: {
    storeScheduleLessonItem(_context, parameter) {
      return new Promise((resolve, reject) => {
        apiHandler
          .post(`${scheduleLessonItemApiUrl}/store`, parameter)
          .then((response) => {
            resolve(response)
          })
          .catch((errors) => {
            reject(errors)
          })
      })
    },
    fetchScheduleLessonItems(context, parameter) {
      return new Promise((resolve, reject) => {
        apiHandler
          .get(`${scheduleLessonItemApiUrl}`, { params: parameter })
          .then((response) => {
            context.commit('setScheduleLessonItems', response.data.data)
            resolve(response)
          })
          .catch((errors) => {
            reject(errors)
          })
      })
    },
  },
}

export default scheduleLessonItem
