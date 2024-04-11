import App from "./common/App";
import LoadingView from "./common/LoadingView";
import FloatButton from "./common/FloatButton";
import FixedBottom from "./common/FixedBottom";
import ApiService from "./utils/ApiService";

Vue.component('loading-view', LoadingView);
Vue.component('float-button', FloatButton);
Vue.component('fixed-bottom', FixedBottom);
Vue.prototype.setBackgroundColor = function (color) {
    document.querySelector("html").setAttribute("style", "background-color:" + color);
}
Vue.prototype.$get = (url, config = {}) => {
    return ApiService.get(url, config);
};
Vue.prototype.$post = (url, data, config = {}) => {
    return ApiService.post(url, data, config);
};

Vue.prototype.$request = (config = {}) => {
    return ApiService.request(config);
}

const router = require('./router');
const store = require('./vuex/store');

new Vue({
    router,
    store,
    render(h) {
        return h(App);
    }
}).$mount('#app');
