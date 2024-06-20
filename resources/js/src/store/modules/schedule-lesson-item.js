import { apiHandler } from '@/plugins/api-handler'

const scheduleLessonApiUrl = 'schedule-lesson-item'

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
    fetchScheduleLessonItems(context, parameter) {
      return new Promise((resolve, reject) => {
        apiHandler
          .get(`${scheduleLessonApiUrl}`, { params: parameter })
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
