import Vue from 'vue';
import Vuex from 'vuex';
import showToast from '../apps/lib/toast';
import VueClipBoard from 'vue-clipboard2'
import Validate from "gzdsx-validate";

Vue.use(Vuex);
Vue.use(VueClipBoard);
Vue.use(showToast);

Vue.prototype.$validator = Validate;

window.Vue = Vue;