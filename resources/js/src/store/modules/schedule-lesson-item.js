import { apiHandler } from '@/plugins/api-handler'

const scheduleLessonItemApiUrl = 'schedule-lesson-item'

const scheduleLessonItem = {
  namespaced: true,
  state: () => ({
    scheduleLessonItems: [],
    scheduleLessonItem: null,
    error: null,
  }),
  getters: {
    getScheduleLessonItems(state) {
      return state.scheduleLessonItems
    },
  },
  mutations: {
    setScheduleLessonItem(state, data) {
      state.scheduleLessonItem = data
    },
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
    fetchDetailScheduleLessonItem(context, parameter) {
      return new Promise((resolve, reject) => {
        apiHandler
          .get(`${scheduleLessonItemApiUrl}/${parameter.id}`)
          .then((response) => {
            response.data.data['schedule_day_id'] =
              response.data.data.schedule_lesson_hour.schedule_day.id
            context.commit('setScheduleLessonItem', response.data.data)
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
            response.data.data = response.data.data.sort((a, b) => {
              return (
                a.schedule_lesson_hour.order_direction -
                b.schedule_lesson_hour.order_direction
              )
            })
            context.commit('setScheduleLessonItems', response.data.data)
            resolve(response)
          })
          .catch((errors) => {
            reject(errors)
          })
      })
    },
    updateScheduleLessonItem(_context, parameter) {
      return new Promise((resolve, reject) => {
        apiHandler
          .put(`${scheduleLessonItemApiUrl}/update/${parameter.id}`, parameter)
          .then((response) => {
            resolve(response)
          })
          .catch((errors) => {
            reject(errors)
          })
      })
    },
    destroyScheduleLessonItem(_context, parameter) {
      return new Promise((resolve, reject) => {
        apiHandler
          .delete(`${scheduleLessonItemApiUrl}/destroy/${parameter.id}`)
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

export default scheduleLessonItem
