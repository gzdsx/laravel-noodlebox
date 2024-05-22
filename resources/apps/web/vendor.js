import Vue from 'vue';
import Vuex from 'vuex';
import showToast from '../lib/toast';
import VueClipBoard from 'vue-clipboard2'
import Validate from "gzdsx-validate";
import NoodleContainer from "./components/NoodleContainer.vue";
import NoodleDialog from "./components/NoodleDialog.vue";

Vue.use(Vuex);
Vue.use(VueClipBoard);
Vue.use(showToast);

Vue.prototype.$validator = Validate;
Vue.component('noodle-container', NoodleContainer);
Vue.component('noodle-dialog', NoodleDialog);

window.Vue = Vue;