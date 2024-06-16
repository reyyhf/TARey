import './bootstrap';
import Vue from 'vue';

import App from '@/App.vue';
import vuetify from '@/plugins/vuetify';
import router from '@/routes';
import store from '@/store';

import '@/plugins/components';
import '@/plugins/validation';
import '@/styles/main.scss';

new Vue({
    router,
    store,
    vuetify,
    render: function (h) { return h(App) }
}).$mount('#app');
