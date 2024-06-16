import { apiHandler } from "@/plugins/api-handler";

const teacherApiUrl = 'teacher';

const teacher = {

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
        fetchTeacher(context) {
            return new Promise((resolve, reject) => {
                apiHandler.get(`${teacherApiUrl}`)
                    .then((response) => {
                        context.commit('setUser', response.data.data);
                        resolve(response);
                    }).catch((errors) => {
                        reject(errors);
                    })
            });
        },
    }
};

export default teacher;
