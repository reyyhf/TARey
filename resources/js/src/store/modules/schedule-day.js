import { apiHandler } from "@/plugins/api-handler";

const scheduleDayApiUrl = 'schedule-day';

const scheduleDay = {

    namespaced: true,

    state: () => ({
        errors: null,
        scheduleDay: [],
    }),

    getters: {
        getScheduleDay(state) {
            return state.scheduleDay;
        },

    },

    mutations: {
        setScheduleDay(state, data) {
            state.scheduleDay = data;
        },
    },

    actions: {

        fetchScheduleDay(context) {
            return new Promise((resolve, reject) => {
                apiHandler.get(`${scheduleDayApiUrl}`)
                    .then((response) => {
                        context.commit('setScheduleDay', response.data.data);
                        resolve(response);
                    }).catch((errors) => {
                        reject(errors);
                    })
            });
        },

        fetchDetailScheduleDay(context, parameter) {
            return new Promise((resolve, reject) => {
                apiHandler.get(`${scheduleDayApiUrl}/${parameter.id}`)
                    .then((response) => {
                        context.commit('setScheduleDay', response.data.data);
                        resolve(response);
                    }).catch((errors) => {
                        reject(errors);
                    })
            });
        },

        updateScheduleDay(context, parameter) {
            return new Promise((resolve, reject) => {
                apiHandler.put(`${scheduleDayApiUrl}/update/${parameter.id}`, parameter)
                    .then((response) => {
                        resolve(response);
                    }).catch((errors) => {
                        reject(errors);
                    })
            });
        },

    }
};

export default scheduleDay;
