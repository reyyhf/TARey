import { apiHandler } from "@/plugins/api-handler";

const userRoleAccessApiUrl = 'role-access';

const userRoleAccess = {

    namespaced: true,

    state: () => ({
        errors: null,
        userRoleAccess: [],
    }),

    getters: {
        getUserRoleAccess(state) {
            return state.userRoleAccess;
        },

    },

    mutations: {
        setUserRoleAccess(state, data) {
            state.userRoleAccess = data;
        },
    },

    actions: {

        fetchUserRoleAccess(context) {
            return new Promise((resolve, reject) => {
                apiHandler.get(`${userRoleAccessApiUrl}`)
                    .then((response) => {
                        context.commit('setUserRoleAccess', response.data.data);
                        resolve(response);
                    }).catch((errors) => {
                        reject(errors);
                    })
            });
        },

    }
};

export default userRoleAccess;
