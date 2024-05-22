<template>
    <div id="paypal-buttons-id"></div>
</template>

<script>
import {loadScript} from "@paypal/paypal-js";
import * as uuid from 'uuid';
import HttpClient from "../HttpClient";

let paypal;
export default {
    name: "PaypalButtons",
    props: {
        order: {
            type: Object,
            default() {
                return {
                    id: '',
                    total: 100,
                    currency: 'EUR',
                    payment_method: 'paypal',
                    payment_method_title: 'PayPal',
                    transaction_id: '',
                    status: 'pending',
                    shipping_lines: [],
                    billing: {
                        first_name: '',
                        last_name: '',
                        company: '',
                        address_1: '',
                        address_2: '',
                        city: '',
                        state: '',
                        postcode: '',
                        country: '',
                        email: '',
                        phone: '',
                    },
                    shipping: {
                        first_name: 'David',
                        last_name: 'Song',
                        company: '',
                        address_1: 'zhongyangdajie',
                        address_2: '',
                        city: 'Guiyang',
                        state: 'Guizhou',
                        postcode: '558300',
                        country: 'China',
                        email: '307718818@qq.com',
                        phone: '18685849696',
                    },
                    line_items: [],
                    meta_data: [],
                }
            }
        },
        card: {
            type: Object,
            default() {
                return {
                    id: uuid.v4(),
                    name: 'card',
                    number: '5298680048963093',
                    expiry: '2024-07'
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
                let {order, card} = this;
                let {shipping} = order;
                paypal
                    .Buttons({
                        createOrder: async (data, actions) => {
                            // return actions.order.create({
                            //     purchase_units: [
                            //         {
                            //             reference_id: uuid.v4(),
                            //             amount: {
                            //                 value: order.total,
                            //             },
                            //         },
                            //     ],
                            //     payment_source: {
                            //         //card,
                            //         paypal: {
                            //             name: {
                            //                 given_name: shipping.first_name,
                            //                 surname: shipping.last_name,
                            //             },
                            //             email_address: shipping.email,
                            //             phone: {
                            //                 phone_number: {
                            //                     national_number: shipping.phone,
                            //                 },
                            //             },
                            //             address: {
                            //                 address_line_1: shipping.address_1,
                            //                 address_line_2: shipping.address_2,
                            //                 admin_area_2: shipping.city,
                            //                 admin_area_1: shipping.state,
                            //                 postal_code: shipping.postcode,
                            //                 country_code: 'IE',
                            //             },
                            //             experience_context: {
                            //                 user_action: "PAY_NOW",
                            //                 payment_method_preference: "IMMEDIATE_PAYMENT_REQUIRED",
                            //             }
                            //         },
                            //
                            //     }
                            // });

                            let response = await HttpClient.post('/payment/paypal/create-order', {order, card});
                            if (response.data.id) {
                                return response.data.id
                            } else {
                                throw new Error(response.message);
                            }
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

        console.log(uuid.v4());
    }
}
</script>

<style scoped>

</style>