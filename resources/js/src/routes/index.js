import Vue from 'vue';
import VueRouter from 'vue-router';
import routes from './routes';
import store from '@/store';

Vue.use(VueRouter)

const router = new VueRouter({
    mode: 'history',
    routes
})

const DEFAULT_TITLE = 'Aplikasi Penjadwalan';

router.beforeEach(async (to, from, next) => {

    let isAuthenticated = store.getters['authentication/getIsAuthenticated'];

    if (!isAuthenticated && to.name != "login-page" && to.meta.auth) {
        return next({ name: "login-page" });
    }

    if (isAuthenticated) {
        let user = store.getters['authentication/getUser'];

        if (!user) {
            let setUnauthorized = false
            await store.dispatch('authentication/getProfile').catch(() => {
                setUnauthorized = true
            })

            if (setUnauthorized) {
                store.commit('authentication/setUnauthorized')
                next({ name: 'login-page' })
                return
            }

            user = store.getters['authentication/getUser']
        }

        if (to.name == 'login-page') {
            next({ name: 'homepage' })
            return
        }

        next()
        return
    }

    return next();
});

router.afterEach((to) => {

    let title = to.meta.auth ? 'Dashboard' : DEFAULT_TITLE;

    Vue.nextTick(() => {
        document.title = title + ' - ' + to.meta.title || title;
    });

});

export default router
