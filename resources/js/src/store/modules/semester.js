import { apiHandler } from "@/plugins/api-handler";

const semesterApiUrl = 'semester';

const semester = {

    namespaced: true,

    state: () => ({
        errors: null,
        semester: [],
    }),

    getters: {
        getSemester(state) {
            return state.semester;
        },

    },

    mutations: {
        setSemester(state, data) {
            state.semester = data;
        },
    },

    actions: {

        fetchSemester(context) {
            return new Promise((resolve, reject) => {
                apiHandler.get(`${semesterApiUrl}`)
                    .then((response) => {
                        context.commit('setSemester', response.data.data);
                        resolve(response);
                    }).catch((errors) => {
                        reject(errors);
                    })
            });
        },

        fetchActiveSemester(context) {
            return new Promise((resolve, reject) => {
                apiHandler.get(`${semesterApiUrl}/active`)
                    .then((response) => {
                        context.commit('setSemester', response.data.data);
                        resolve(response);
                    }).catch((errors) => {
                        reject(errors);
                    })
            });
        },

        fetchDetailSemester(context, parameter) {
            return new Promise((resolve, reject) => {
                apiHandler.get(`${semesterApiUrl}/${parameter.id}`)
                    .then((response) => {
                        context.commit('setSemester', response.data.data);
                        resolve(response);
                    }).catch((errors) => {
                        reject(errors);
                    })
            });
        },

        storeSemester(context, parameter) {
            return new Promise((resolve, reject) => {
                apiHandler.post(`${semesterApiUrl}/store`, parameter)
                    .then((response) => {
                        resolve(response);
                    }).catch((errors) => {
                        reject(errors);
                    })
            });
        },

        updateSemester(context, parameter) {
            return new Promise((resolve, reject) => {
                apiHandler.put(`${semesterApiUrl}/update/${parameter.id}`, parameter)
                    .then((response) => {
                        resolve(response);
                    }).catch((errors) => {
                        reject(errors);
                    })
            });
        },

        destroySemester(context, parameter) {
            return new Promise((resolve, reject) => {
                apiHandler.delete(`${semesterApiUrl}/destroy/${parameter.id}`)
                    .then((response) => {
                        resolve(response);
                    }).catch((errors) => {
                        reject(errors);
                    })
            });
        },

    }
};

export default semester;
