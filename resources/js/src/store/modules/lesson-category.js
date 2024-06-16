import { apiHandler } from "@/plugins/api-handler";

const lessonCategoryApiUrl = 'lesson-category';

const lessonCategory = {

    namespaced: true,

    state: () => ({
        errors: null,
        lessonCategory: [],
    }),

    getters: {
        getLessonCategory(state) {
            return state.lessonCategory;
        },

    },

    mutations: {
        setLessonCategory(state, data) {
            state.lessonCategory = data;
        },
    },

    actions: {

        fetchLessonCategory(context) {
            return new Promise((resolve, reject) => {
                apiHandler.get(`${lessonCategoryApiUrl}`)
                    .then((response) => {
                        context.commit('setLessonCategory', response.data.data);
                        resolve(response);
                    }).catch((errors) => {
                        reject(errors);
                    })
            });
        },

        fetchDetailLessonCategory(context, parameter) {
            return new Promise((resolve, reject) => {
                apiHandler.get(`${lessonCategoryApiUrl}/${parameter.id}`)
                    .then((response) => {
                        context.commit('setLessonCategory', response.data.data);
                        resolve(response);
                    }).catch((errors) => {
                        reject(errors);
                    })
            });
        },

        storeLessonCategory(context, parameter) {
            return new Promise((resolve, reject) => {
                apiHandler.post(`${lessonCategoryApiUrl}/store`, parameter)
                    .then((response) => {
                        resolve(response);
                    }).catch((errors) => {
                        reject(errors);
                    })
            });
        },

        updateLessonCategory(context, parameter) {
            return new Promise((resolve, reject) => {
                apiHandler.put(`${lessonCategoryApiUrl}/update/${parameter.id}`, parameter)
                    .then((response) => {
                        resolve(response);
                    }).catch((errors) => {
                        reject(errors);
                    })
            });
        },

        destroyLessonCategory(context, parameter) {
            return new Promise((resolve, reject) => {
                apiHandler.delete(`${lessonCategoryApiUrl}/destroy/${parameter.id}`)
                    .then((response) => {
                        resolve(response);
                    }).catch((errors) => {
                        reject(errors);
                    })
            });
        },

    }
};

export default lessonCategory;
