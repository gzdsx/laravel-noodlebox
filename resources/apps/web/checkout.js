import NoodleCheckout from "./checkout/NoodleCheckout.vue";

new Vue({
    el: '#checkoutApp',
    render: function (h) {
        return h(NoodleCheckout)
    }
});