import MainApp from './layout/MainApp';
import MainLayout from "./layout/MainLayout";
import FixedBottom from "./layout/FixedBottom";
import ApiService from "./utils/ApiService";
import LocationDialog from "./components/LocationDialog";
import FeaturedImage from "./components/FeaturedImage";
import AuthService from "./utils/AuthService";
import router, {resetRouter} from "./router";
import addRoutes from "./utils/addRoutes";
import WangEditor from "./components/wangedit/WangEditor.vue";
import MediaDialog from "./components/MediaDialog.vue";

Vue.component('location-dialog', LocationDialog);
Vue.component('main-layout', MainLayout);
Vue.component('fixed-bottom', FixedBottom);
Vue.component('featured-image', FeaturedImage);
Vue.component('wang-editor', WangEditor);
Vue.component('media-dialog', MediaDialog);

const routeContext = require.context('../', true, /routes\.js$/);
routeContext.keys().forEach(key => {
    const routes = routeContext(key);
    addRoutes(router, routes, 'administrator');
});

router.beforeEach(async (to, from, next) => {
    let {title} = to.meta;
    if (title) {
        document.title = title;
    }

    const hasToken = AuthService.getToken();
    if (!hasToken) {
        window.location.assign('/vue-admin/login');
    } else {
        next();
    }
    // if (hasToken) {
    //     if (to.name === 'login') {
    //         next('/');
    //     } else {
    //         next();
    //     }
    // } else {
    //     if (to.name === 'login') {
    //         next();
    //     } else {
    //         next('/login');
    //     }
    // }
});

const store = require('./store');
ApiService.get('/locale/messages').then(response => {
    const {locale, messages} = response.data;
    const i18n = new VueI18n({
        locale,
        messages
    });

    new Vue({
        i18n,
        router,
        store,
        render(h) {
            return h(MainApp);
        },
        created() {
            //this.$i18n.setLocaleMessage('locale', response.data.messages);
            ApiService.get('/user/info').then(response => {
                store.commit('signin', response.data);
                resetRouter();
                const capability = response.data.capability || '';
                const context = require.context('../', true, /routes\.js$/);
                context.keys().forEach(key => {
                    const routes = context(key);
                    addRoutes(router, routes, capability);
                });
            });
        }
    }).$mount('#app');
});
