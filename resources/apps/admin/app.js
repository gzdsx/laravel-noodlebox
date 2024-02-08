import vuedraggable from 'vuedraggable';
import MainApp from './layout/MainApp';
import MainLayout from "./layout/MainLayout";
import FixedBottom from "./layout/FixedBottom";
import MediaDialog from "./components/MediaDialog";
import VueClipboard from 'vue-clipboard2';
import ApiService from "./utils/ApiService";
import LocationDialog from "./components/LocationDialog";
import WangEditor from "./components/wangedit/WangEditor";
import FeaturedImage from "./components/FeaturedImage";
import VueI18n from 'vue-i18n';
import Validate from "gzdsx-validate";
import AuthService from "./utils/AuthService";

Vue.use(VueClipboard);
Vue.use(VueI18n);

Vue.component('vuedraggable', vuedraggable);
Vue.component('wang-editor', WangEditor);
Vue.component('media-dialog', MediaDialog);
Vue.component('location-dialog', LocationDialog);
Vue.component('main-layout', MainLayout);
Vue.component('fixed-bottom', FixedBottom);
Vue.component('featured-image', FeaturedImage);

Vue.prototype.$get = (url, config = {}) => {
    return ApiService.get(url, config);
};
Vue.prototype.$post = (url, data, config = {}) => {
    return ApiService.post(url, data, config);
};

Vue.prototype.$request = (config = {}) => {
    return ApiService.request(config);
}

Vue.prototype.$validate = Validate;
Vue.prototype.$lang = 'zh_CN';

window._ = require('lodash');

const router = require('./router');
const store = require('./store');

router.beforeEach(async (to, from, next) => {
    //console.log(store.state.auth);
    let {title} = to.meta;
    if (title) {
        document.title = title + '-后台管理中心';
    }

    const hasToken = AuthService.getToken();
    if (hasToken) {
        if (to.name === 'login') {
            next('/');
        } else {
            next();
        }
    } else {
        if (to.name === 'login') {
            next();
        } else {
            next('/login');
        }
    }
});

const i18n = new VueI18n({
    locale: 'locale',
    messages: {}
});

new Vue({
    i18n,
    router,
    store,
    render(h) {
        return h(MainApp);
    }
}).$mount('#app');
