import Vue from "vue";
import request from "./request";
import PropertyApp from "./components/property/PropertyApp.vue";
import VueSlider from 'vue-slider-component'
import 'vue-slider-component/theme/antd.css'
import showToast from '../apps/lib/toast';

Vue.use(showToast);
Vue.component('VueSlider', VueSlider);

Vue.prototype.$http = request;

new Vue({
    el: '#properties-app',
    render(h) {
        return h(PropertyApp);
    }
});