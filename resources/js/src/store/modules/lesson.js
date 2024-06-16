import { apiHandler } from "@/plugins/api-handler";

const lessonApiUrl = 'lesson';

const lesson = {

    namespaced: true,

    state: () => ({
        errors: null,
        lesson: [],
    }),

    getters: {
        getlesson(state) {
            return state.lesson;
        },

    },

    mutations: {
        setlesson(state, data) {
            state.lesson = data;
        },
    },

    actions: {

        fetchLesson(context) {
            return new Promise((resolve, reject) => {
                apiHandler.get(`${lessonApiUrl}`)
                    .then((response) => {
                        context.commit('setlesson', response.data.data);
                        resolve(response);
                    }).catch((errors) => {
                        reject(errors);
                    })
            });
        },

        fetchDetailLesson(context, parameter) {
            return new Promise((resolve, reject) => {
                apiHandler.get(`${lessonApiUrl}/${parameter.id}`)
                    .then((response) => {
                        context.commit('setlesson', response.data.data);
                        resolve(response);
                    }).catch((errors) => {
                        reject(errors);
                    })
            });
        },

        storeLesson(context, parameter) {
            return new Promise((resolve, reject) => {
                apiHandler.post(`${lessonApiUrl}/store`, parameter)
                    .then((response) => {
                        resolve(response);
                    }).catch((errors) => {
                        reject(errors);
                    })
            });
        },

        updateLesson(context, parameter) {
            return new Promise((resolve, reject) => {
                apiHandler.put(`${lessonApiUrl}/update/${parameter.id}`, parameter)
                    .then((response) => {
                        resolve(response);
                    }).catch((errors) => {
                        reject(errors);
                    })
            });
        },

        destroyLesson(context, parameter) {
            return new Promise((resolve, reject) => {
                apiHandler.delete(`${lessonApiUrl}/destroy/${parameter.id}`)
                    .then((response) => {
                        resolve(response);
                    }).catch((errors) => {
                        reject(errors);
                    })
            });
        },

    }
};

export default lesson;
