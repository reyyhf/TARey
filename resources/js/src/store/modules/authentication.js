import { apiHandler, initApiHandler } from "@/plugins/api-handler";

const authenticationApiUrl = 'auth';

const authentication = {

    namespaced: true,

    state: () => ({
        isAuthenticated: !!localStorage.getItem('app_access'),
        user: null,
    }),

    getters: {
        getIsAuthenticated(state) {
            return state.isAuthenticated;
        },

        getUser(state) {
            return state.user;
        }
    },

    mutations: {
        setIsAuthenticated(state, { value, token }) {
            localStorage.setItem('app_access', token);
            state.isAuthenticated = value;
        },

        setUnauthorized(state) {
            localStorage.removeItem('app_access')
            state.isAuthenticated = false
        },

        setUser(state, params) {
            state.user = params;
        }
    },

    actions: {

        login(context, parameter) {
            return new Promise((resolve, reject) => {
                apiHandler.post(`${authenticationApiUrl}/login`, parameter)
                    .then((response) => {
                        let result = response.data.data;

                        context.commit('setIsAuthenticated', {
                            value: true,
                            token: result.access_token
                        });
                        initApiHandler();
                        resolve(response);
                    }).catch((errors) => {
                        reject(errors);
                    })
            });
        },

        getProfile(context) {
            return new Promise((resolve, reject) => {
                apiHandler.get(`${authenticationApiUrl}/current-user`)
                    .then((response) => {
                        context.commit('setUser', {
                            ...response.data.data
                        });
                        resolve(response);
                    }).catch((errors) => {
                        reject(errors);
                    })
            });
        },

        logout(context) {
            return new Promise((resolve, reject) => {
                apiHandler.get(`${authenticationApiUrl}/logout`)
                    .then((response) => {
                        context.commit('setUnauthorized');
                        resolve(response);
                    }).catch((errors) => {
                        reject(errors);
                    })
            });
        },
    }
};

export default authentication;
