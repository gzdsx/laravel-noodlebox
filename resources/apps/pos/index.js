import Vue from "vue";
import VueRouter from 'vue-router';
import * as vClickOutside from 'v-click-outside-x';
import dayjs from "dayjs";
import Vuex from 'vuex';
import request from "./request";
import Main from "./components/Main";
import PosDialog from "./components/PosDialog";
import PosLoading from "./components/PosLoading.vue";
import PosConfirm from "./components/confirm";
import PosApp from "./components/PosApp.vue";
import PosInput from './components/Input.vue';

Vue.use(Vuex);
Vue.use(VueRouter);
Vue.use(vClickOutside);
Vue.use(PosConfirm);
Vue.component(PosDialog.name, PosDialog);
Vue.component(PosLoading.name, PosLoading);
Vue.component(PosInput.name, PosInput);

Vue.prototype.$beep = new Audio(window.location.origin + '/images/pos/beep.mp3');
Vue.prototype.$toAmount = function (v) {
    if (!/\d+/.test(v)) {
        return '0.00';
    }
    return parseFloat(v).toFixed(2);
}

Vue.prototype.$dayjs = dayjs;
Vue.prototype.$http = request;
Vue.prototype.$uniqid = function () {
    return Math.random().toString(36).substr(2, 9);
}

const router = new VueRouter({
    routes: [
        {path: '/', component: PosApp}
    ]
});

const isLoggedIn = localStorage.getItem('accessToken');
const store = new Vuex.Store({
    state: {
        customer: {
            id: 0,
            first_name: 'Guest',
            last_name: '',
            email: '',
            avatar_url: '',
            shipping: {},
            billing: {},
        },
        isLoggedIn,
        shippingMethod:''
    },
    mutations: {
        setCustomer(state, customer) {
            state.customer = customer;
        },
        setIsLoggedIn(state, isLoggedIn) {
            state.isLoggedIn = isLoggedIn;
        },
        setShippingMethod(state, shippingMethod) {
            state.shippingMethod = shippingMethod;
        }
    }
});

Vue.filter('capitalize', function (value) {
    if (!value) return ''
    value = value.toString()
    return value.charAt(0).toUpperCase() + value.slice(1);
})

new Vue({
    router,
    store,
    render(createElement, hack) {
        return createElement(Main);
    }
}).$mount('#app');