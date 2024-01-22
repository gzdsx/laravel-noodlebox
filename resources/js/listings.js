import Vue from "vue";
import request from "./request";
import ListingsApp from "./components/buildium/ListingsApp";
import VueSlider from 'vue-slider-component';
import 'vue-slider-component/theme/antd.css';
import showToast from '../apps/lib/toast';

Vue.use(showToast);

Vue.component('VueSlider', VueSlider);

Vue.prototype.$http = request;
window.Vue = Vue;

new Vue({
    el: '#listings-app',
    render(h) {
        return h(ListingsApp);
    }
});