import { apiHandler } from "@/plugins/api-handler";

const classroomApiUrl = 'classroom';

const classroom = {

    namespaced: true,

    state: () => ({
        errors: null,
        classroom: [],
    }),

    getters: {
        getClassroom(state) {
            return state.classroom;
        },

    },

    mutations: {
        setClassroom(state, data) {
            state.classroom = data;
        },
    },

    actions: {

        fetchClassroom(context) {
            return new Promise((resolve, reject) => {
                apiHandler.get(`${classroomApiUrl}`)
                    .then((response) => {
                        context.commit('setClassroom', response.data.data);
                        resolve(response);
                    }).catch((errors) => {
                        reject(errors);
                    })
            });
        },

        fetchClassroomLabel(context) {
            return new Promise((resolve, reject) => {
                apiHandler.get(`classroom-label`)
                    .then((response) => {
                        context.commit('setClassroom', response.data.data);
                        resolve(response);
                    }).catch((errors) => {
                        reject(errors);
                    })
            });
        },

        fetchDetailClassroom(context, parameter) {
            return new Promise((resolve, reject) => {
                apiHandler.get(`${classroomApiUrl}/${parameter.id}`)
                    .then((response) => {
                        context.commit('setClassroom', response.data.data);
                        resolve(response);
                    }).catch((errors) => {
                        reject(errors);
                    })
            });
        },

        storeClassroom(context, parameter) {
            return new Promise((resolve, reject) => {
                apiHandler.post(`${classroomApiUrl}/store`, parameter)
                    .then((response) => {
                        resolve(response);
                    }).catch((errors) => {
                        reject(errors);
                    })
            });
        },

        updateClassroom(context, parameter) {
            return new Promise((resolve, reject) => {
                apiHandler.put(`${classroomApiUrl}/update/${parameter.id}`, parameter)
                    .then((response) => {
                        resolve(response);
                    }).catch((errors) => {
                        reject(errors);
                    })
            });
        },

        destroyClassroom(context, parameter) {
            return new Promise((resolve, reject) => {
                apiHandler.delete(`${classroomApiUrl}/destroy/${parameter.id}`)
                    .then((response) => {
                        resolve(response);
                    }).catch((errors) => {
                        reject(errors);
                    })
            });
        },

    }
};

export default classroom;
