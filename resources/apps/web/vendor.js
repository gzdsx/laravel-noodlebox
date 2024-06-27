import Vue from 'vue';
import Vuex from 'vuex';
import dayjs from "dayjs";
import axios from "axios";
import {BootstrapVue, IconsPlugin} from 'bootstrap-vue'
import showToast from '../lib/toast';
import VueClipBoard from 'vue-clipboard2'
import Validate from "gzdsx-validate";
import NoodleContainer from "./components/NoodleContainer.vue";
import NoodleDialog from "./components/NoodleDialog.vue";

Vue.use(Vuex);
Vue.use(VueClipBoard);
Vue.use(showToast);
Vue.use(BootstrapVue);

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

Vue.prototype.$axios = axios;
Vue.prototype.$dayjs = dayjs;
Vue.prototype.$validator = Validate;
Vue.component('noodle-container', NoodleContainer);
Vue.component('noodle-dialog', NoodleDialog);

window.Vue = Vue;
window.axios = axios;