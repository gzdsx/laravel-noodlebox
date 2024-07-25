<template>
    <div id="paypal-buttons-id"></div>
</template>

<script>
import {loadScript} from "@paypal/paypal-js";

let paypal;
export default {
    name: "PaypalButtons",
    props: {
        clientId: {
            type: String,
            default: ''
        },
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
        },
        onError: {
            type: Function,
            default() {
                return (err) => {

                }
            }
        },
        onInit: {
            type: Function,
            default() {
                return (data, actions) => {

                }
            }
        },
        onClick: {
            type: Function,
            default() {
                return (data, actions) => {

                }
            }
        },
    },
    methods: {},
    mounted() {
        loadScript({
            clientId: this.clientId,
            currency: 'EUR',
            components: ["buttons"],
            dataPageType: "checkout",
        }).then((paypalObj) => {
            paypal = paypalObj;
            this.$nextTick(() => {
                paypal.Buttons({
                    onInit: (data, actions) => {

                    },
                    onClick: async (data, actions) => {
                        return this.onClick(data, actions);
                    },
                    createOrder: async (data, actions) => {
                        //console.log(data);
                        //console.log(actions);
                        return this.createOrder(data, actions);
                    },
                    onApprove: async (data, actions) => {
                        return this.onApprove(data, actions);
                    },
                    onCancel: async (data, actions) => {
                        console.log('onCancel', data);
                        return this.onCancel(data, actions);
                    },
                    onError: async (err) => {
                        return this.onError(err);
                    }
                }).render("#paypal-buttons-id")
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