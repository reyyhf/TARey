import { apiHandler } from "@/plugins/api-handler";

const scheduleLessonApiUrl = "schedule-lesson";

const scheduleLesson = {
    namespaced: true,
    state: () => ({
        scheduleLessons: [],
        error: null,
    }),
    getters: {
        getScheduleLessons(state) {
            return state.scheduleLessons;
        },
    },
    mutations: {
        setScheduleLessons(state, data) {
            state.scheduleLessons = data;
        },
    },
    actions: {
        fetchScheduleLessons(context, parameter) {
            return new Promise((resolve, reject) => {
                apiHandler
                    .get(`${scheduleLessonApiUrl}`, { params: parameter })
                    .then((response) => {
                        context.commit(
                            "setScheduleLessons",
                            response.data.data
                        );
                        resolve(response);
                    })
                    .catch((errors) => {
                        reject(errors);
                    });
            });
        },
    },
};

export default scheduleLesson;
