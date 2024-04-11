import NoodleCart from "./components/NoodleCart.vue";

new Vue({
    el: '#cartApp',
    render: function (h) {
        return h(NoodleCart);
    }
});