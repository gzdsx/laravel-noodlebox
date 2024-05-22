import NoodleCart from "./cart/NoodleCart.vue";

new Vue({
    el: '#cartApp',
    render: function (h) {
        return h(NoodleCart);
    }
});