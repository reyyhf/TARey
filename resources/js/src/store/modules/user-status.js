import { apiHandler } from "@/plugins/api-handler";

const userStatusApiUrl = 'user-status';

const userStatus = {

    namespaced: true,

    state: () => ({
        errors: null,
        userStatus: [],
    }),

    getters: {
        getUserStatus(state) {
            return state.userStatus;
        },

    },

    mutations: {
        setUserStatus(state, data) {
            state.userStatus = data;
        },
    },

    actions: {

        fetchUserStatus(context) {
            return new Promise((resolve, reject) => {
                apiHandler.get(`${userStatusApiUrl}`)
                    .then((response) => {
                        context.commit('setUserStatus', response.data.data);
                        resolve(response);
                    }).catch((errors) => {
                        reject(errors);
                    })
            });
        },

        fetchDetailUserStatus(context, parameter) {
            return new Promise((resolve, reject) => {
                apiHandler.get(`${userStatusApiUrl}/${parameter.id}`)
                    .then((response) => {
                        context.commit('setUserStatus', response.data.data);
                        resolve(response);
                    }).catch((errors) => {
                        reject(errors);
                    })
            });
        },

        storeUserStatus(context, parameter) {
            return new Promise((resolve, reject) => {
                apiHandler.post(`${userStatusApiUrl}/store`, parameter)
                    .then((response) => {
                        resolve(response);
                    }).catch((errors) => {
                        reject(errors);
                    })
            });
        },

        updateUserStatus(context, parameter) {
            return new Promise((resolve, reject) => {
                apiHandler.put(`${userStatusApiUrl}/update/${parameter.id}`, parameter)
                    .then((response) => {
                        resolve(response);
                    }).catch((errors) => {
                        reject(errors);
                    })
            });
        },

        destroyUserStatus(context, parameter) {
            return new Promise((resolve, reject) => {
                apiHandler.delete(`${userStatusApiUrl}/destroy/${parameter.id}`)
                    .then((response) => {
                        resolve(response);
                    }).catch((errors) => {
                        reject(errors);
                    })
            });
        },

    }
};

export default userStatus;
