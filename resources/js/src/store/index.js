import Vue from "vue";
import Vuex from "vuex";

import userRoleAccess from "./modules/user-role-access";
import lessonCategory from "./modules/lesson-category";
import classroom from "./modules/classroom";
import userStatus from "./modules/user-status";
import lesson from "./modules/lesson";
import semester from "./modules/semester";
import scheduleDay from "./modules/schedule-day";
import user from "./modules/user";
import teacher from "./modules/teacher";
import authentication from "./modules/authentication";
import curriculum from "./modules/curriculum";
import scheduleLessonHour from "./modules/schedule-lesson-hour";
import scheduleLesson from "./modules/schedule-lesson";
import criteriaConstraint from "./modules/criteria-constraint";

const listModules = {
    authentication,
    userRoleAccess,
    lessonCategory,
    classroom,
    userStatus,
    lesson,
    semester,
    scheduleDay,
    user,
    teacher,
    curriculum,
    scheduleLessonHour,
    scheduleLesson,
    criteriaConstraint
};

Vue.use(Vuex);

export default new Vuex.Store({
    modules: listModules,
});
