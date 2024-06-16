import Vue from 'vue';
import { extend, localize } from "vee-validate";
import * as rules from "vee-validate/dist/rules";
import id from "vee-validate/dist/locale/id.json";
import { ValidationProvider, ValidationObserver } from 'vee-validate';


Object.keys(rules).forEach(rule => {
    extend(rule, rules[rule]);
});

localize("id", id);

Vue.component('validation-observer', ValidationObserver);
Vue.component('validation-provider', ValidationProvider);
