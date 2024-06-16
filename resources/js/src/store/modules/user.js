import { apiHandler } from "@/plugins/api-handler";

const userApiUrl = 'user';

const user = {

    namespaced: true,

    state: () => ({
        errors: null,
        user: [],
    }),

    getters: {
        getUser(state) {
            return state.user;
        },

    },

    mutations: {
        setUser(state, data) {
            state.user = data;
        },
    },

    actions: {

        fetchUser(context) {
            return new Promise((resolve, reject) => {
                apiHandler.get(`${userApiUrl}`)
                    .then((response) => {
                        context.commit('setUser', response.data.data);
                        resolve(response);
                    }).catch((errors) => {
                        reject(errors);
                    })
            });
        },

        fetchDetailUser(context, parameter) {
            return new Promise((resolve, reject) => {
                apiHandler.get(`${userApiUrl}/${parameter.id}`)
                    .then((response) => {
                        context.commit('setUser', response.data.data);
                        resolve(response);
                    }).catch((errors) => {
                        reject(errors);
                    })
            });
        },

        storeUser(context, parameter) {
            return new Promise((resolve, reject) => {
                apiHandler.post(`${userApiUrl}/store`, parameter)
                    .then((response) => {
                        resolve(response);
                    }).catch((errors) => {
                        reject(errors);
                    })
            });
        },

        updateUser(context, parameter) {
            return new Promise((resolve, reject) => {
                apiHandler.put(`${userApiUrl}/update/${parameter.id}`, parameter)
                    .then((response) => {
                        resolve(response);
                    }).catch((errors) => {
                        reject(errors);
                    })
            });
        },

        destroyUser(context, parameter) {
            return new Promise((resolve, reject) => {
                apiHandler.delete(`${userApiUrl}/destroy/${parameter.id}`)
                    .then((response) => {
                        resolve(response);
                    }).catch((errors) => {
                        reject(errors);
                    })
            });
        },

    }
};

export default user;
