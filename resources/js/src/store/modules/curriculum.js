import { apiHandler } from "@/plugins/api-handler";

const curriculumApiUrl = 'curriculum-lesson';

const curriculum = {

    namespaced: true,

    state: () => ({
        errors: null,
        curriculum: [],
    }),

    getters: {
        getCurriculum(state) {
            return state.curriculum;
        },

    },

    mutations: {
        setCurriculum(state, data) {
            state.curriculum = data;
        },
    },

    actions: {

        fetchCurriculum(context) {
            return new Promise((resolve, reject) => {
                apiHandler.get(`${curriculumApiUrl}`)
                    .then((response) => {
                        context.commit('setCurriculum', response.data.data);
                        resolve(response);
                    }).catch((errors) => {
                        reject(errors);
                    })
            });
        },

        fetchDetailCurriculum(context, parameter) {
            return new Promise((resolve, reject) => {
                apiHandler.get(`${curriculumApiUrl}/${parameter.id}`)
                    .then((response) => {
                        context.commit('setCurriculum', response.data.data);
                        resolve(response);
                    }).catch((errors) => {
                        reject(errors);
                    })
            });
        },

        storeCurriculum(context, parameter) {
            return new Promise((resolve, reject) => {
                apiHandler.post(`${curriculumApiUrl}/store`, parameter)
                    .then((response) => {
                        resolve(response);
                    }).catch((errors) => {
                        reject(errors);
                    })
            });
        },

        updateCurriculum(context, parameter) {
            return new Promise((resolve, reject) => {
                apiHandler.put(`${curriculumApiUrl}/update/${parameter.id}`, parameter)
                    .then((response) => {
                        resolve(response);
                    }).catch((errors) => {
                        reject(errors);
                    })
            });
        },

        destroyCurriculum(context, parameter) {
            return new Promise((resolve, reject) => {
                apiHandler.delete(`${curriculumApiUrl}/destroy/${parameter.id}`)
                    .then((response) => {
                        resolve(response);
                    }).catch((errors) => {
                        reject(errors);
                    })
            });
        },

    }
};

export default curriculum;
