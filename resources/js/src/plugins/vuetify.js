import Vue from 'vue';
import Vuetify from 'vuetify/lib';

Vue.use(Vuetify);

Vuetify.config.silent = true;

const options = {
    theme: {
        options: {
            customProperties: true,
        },
        themes: {
            light: {
                primary: '#1e88e5',
                secondary: '#4effee',
                accent: '#82B1FF',
                error: '#f44336',
                info: '#3949ab',
                success: '#43a047',
                warning: '#FFC107',
                gray: '#9E9E9E',
                black: '#343a40',
            },
        },
    },
};

export default new Vuetify(options);
