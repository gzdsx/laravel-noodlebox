<template>
    <div id="paypal-buttons-id"></div>
</template>

<script>
import {loadScript} from "@paypal/paypal-js";

let paypal;
export default {
    name: "PaypalButtons",
    props: {
        createOrder: {
            type: Function,
            default() {
                return () => {

                }
            }
        },
        onApprove: {
            type: Function,
            default() {
                return (data, actions) => {

                }
            }
        },
        onCancel: {
            type: Function,
            default() {
                return () => {

                }
            }
        }
    },
    methods: {},
    mounted() {
        loadScript({
            clientId: "AZL4d1EcXkCqg2MiEj6yn9SYxq_hRvJ_JyM3nM9RVfdzMmJfZvzCtvvVJjEW_NP5JomB4SIRG_DEF8Sw",
            currency: 'EUR',
            components: ["buttons", "marks", "messages"],
            dataPageType: "checkout",
        }).then((paypalObj) => {
            paypal = paypalObj;
            this.$nextTick(() => {
                let {orderData, card} = this;
                paypal
                    .Buttons({
                        onInit: (data, actions) => {

                        },
                        onClick: async (data, actions) => {

                        },
                        createOrder: async (data, actions) => {
                            return this.createOrder(data, actions);
                        },
                        onApprove: async (data, actions) => {
                            return this.onApprove(data, actions);
                        },
                        onCancel: async (data, actions) => {
                            return this.onCancel(data, actions);
                        },
                        onError: async (err) => {
                            console.log(err);
                        }
                    })
                    .render("#paypal-buttons-id")
                    .catch((error) => {
                        console.error("failed to render the PayPal Buttons", error);
                    });
            });
        }).catch((error) => {
            console.error("failed to load the PayPal JS SDK script", error);
        });
    }
}
</script>

<style scoped>

</style>