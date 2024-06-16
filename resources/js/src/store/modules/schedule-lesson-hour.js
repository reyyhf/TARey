import { apiHandler } from "@/plugins/api-handler";

const scheduleLessonHourApiUrl = 'schedule-lesson-hour';

const scheduleLessonHour = {

    namespaced: true,

    state: () => ({
        errors: null,
        scheduleLessonHour: [],
    }),

    getters: {
        getScheduleLessonHour(state) {
            return state.scheduleLessonHour;
        },

    },

    mutations: {
        setScheduleLessonHour(state, data) {
            state.scheduleLessonHour = data;
        },
    },

    actions: {

        fetchScheduleLessonHour(context, parameter) {
            return new Promise((resolve, reject) => {
                apiHandler.get(`${scheduleLessonHourApiUrl}`, { params: parameter })
                    .then((response) => {
                        context.commit('setScheduleLessonHour', response.data.data);
                        resolve(response);
                    }).catch((errors) => {
                        reject(errors);
                    })
            });
        },

        fetchDetailScheduleLessonHour(context, parameter) {
            return new Promise((resolve, reject) => {
                apiHandler.get(`${scheduleLessonHourApiUrl}/${parameter.id}`)
                    .then((response) => {
                        context.commit('setScheduleLessonHour', response.data.data);
                        resolve(response);
                    }).catch((errors) => {
                        reject(errors);
                    })
            });
        },

        storeScheduleLessonHour(context, parameter) {
            return new Promise((resolve, reject) => {
                apiHandler.post(`${scheduleLessonHourApiUrl}/store`, parameter)
                    .then((response) => {
                        resolve(response);
                    }).catch((errors) => {
                        reject(errors);
                    })
            });
        },

        updateScheduleLessonHour(context, parameter) {
            return new Promise((resolve, reject) => {
                apiHandler.put(`${scheduleLessonHourApiUrl}/update/${parameter.id}`, parameter)
                    .then((response) => {
                        resolve(response);
                    }).catch((errors) => {
                        reject(errors);
                    })
            });
        },

        destroyScheduleLessonHour(context, parameter) {
            return new Promise((resolve, reject) => {
                apiHandler.delete(`${scheduleLessonHourApiUrl}/destroy/${parameter.id}`)
                    .then((response) => {
                        resolve(response);
                    }).catch((errors) => {
                        reject(errors);
                    })
            });
        },

    }
};

export default scheduleLessonHour;
