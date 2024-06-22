import { apiHandler } from "@/plugins/api-handler";

const criteriaConstraintApiUrl = 'criteria-constraint';

const criteriaConstraint = {

    namespaced: true,

    state: () => ({
        errors: null,
        criteriaConstraint: [],
    }),

    getters: {
        getCriteriaConstraint(state) {
            return state.criteriaConstraint;
        },

    },

    mutations: {
        setCriteriaConstraint(state, data) {
            state.criteriaConstraint = data;
        },
    },

    actions: {

        fetchCriteriaConstraint(context) {
            return new Promise((resolve, reject) => {
                apiHandler.get(`${criteriaConstraintApiUrl}`)
                    .then((response) => {
                        context.commit('setCriteriaConstraint', response.data.data);
                        resolve(response);
                    }).catch((errors) => {
                        reject(errors);
                    })
            });
        },

        storeCriteriaConstraint(context, parameter){
            return new Promise((resolve, reject) => {
                apiHandler.post(`${criteriaConstraintApiUrl}/store`, parameter)
                    .then((response) => {
                        resolve(response);
                    }).catch((errors) => {
                        reject(errors);
                    })
            });
        }

    }
}


export default criteriaConstraint;
