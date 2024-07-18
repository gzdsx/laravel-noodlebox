import Vue from "vue";
import Vuex from "vuex";
import VueClipBoard from 'vue-clipboard2'
import Validate from "gzdsx-validate";
import vuedraggable from 'vuedraggable';
import VueI18n from 'vue-i18n';
import VueRouter from "vue-router";
import ElementUI from "element-ui";
import locale from 'element-ui/lib/locale/lang/en'
import ApiService from "./utils/ApiService";

Vue.use(Vuex);
Vue.use(VueClipBoard);
Vue.use(VueI18n);
Vue.use(VueRouter);
Vue.use(ElementUI, {locale});

Vue.component('vuedraggable', vuedraggable);
Vue.prototype.$validator = Validate;

Vue.prototype.$get = (url, config = {}) => {
    return ApiService.get(url, config);
}

Vue.prototype.$post = (url, data, config = {}) => {
    return ApiService.post(url, data, config);
}

Vue.prototype.$request = (config = {}) => {
    return ApiService.request(config);
}

Vue.filter('capitalize', function (value) {
    if (!value) return ''
    value = value.toString()
    return value.charAt(0).toUpperCase() + value.slice(1);
});

window.Vue = Vue;
window.VueI18n = VueI18n;
window.VueRouter = VueRouter;
window.ElementUI = ElementUI;