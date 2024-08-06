<template>
    <div class="container">
        <div class="checkout-body">
            <div class="checkout-col">
                <checkout-shipping
                    :order.sync="order"
                    :shipping-zones.sync="options.shipping_zones"
                    @change="onShippingChange"
                />
                <div class="form-group mt-4">
                    <h5 class="font-weight-bold">Order notes</h5>
                    <div class="form-group__input">
                        <textarea type="text" class="form-control" rows="3" placeholder=""
                                  v-model="order.buyer_note"></textarea>
                    </div>
                </div>
            </div>
            <div class="checkout-col checkout-order">
                <h3 class="font-weight-bold">You order</h3>
                <checkou-items :items="order.items"/>
                <div class="form-group mt-4" v-if="options.enable_points_checkout==='yes'">
                    <checkout-use-points :default-points.sync="order.use_points_value"
                                         @submit="onPointsChange"/>
                </div>
                <div class="order-totals">
                    <div class="order-total">
                        <div class="order-total__label">Subtotal</div>
                        <div class="order-total__total">€{{ order.subtotal }}</div>
                    </div>
                    <div class="order-total">
                        <div class="order-total__label">Shipping</div>
                        <div class="order-total__total">+€{{ order.shipping_total }}</div>
                    </div>
                    <div class="order-total" v-for="(fee,index) in order.fee_lines">
                        <div class="order-total__label">{{ fee.name }}</div>
                        <div class="order-total__total">+€{{ fee.total }}</div>
                    </div>
                    <div class="order-total" v-for="(discount,index) in order.discount_lines">
                        <div class="order-total__label">{{ discount.name }}</div>
                        <div class="order-total__total">-€{{ discount.total }}</div>
                    </div>
                    <div class="order-total">
                        <div class="order-total__label">Total</div>
                        <div class="order-total__total">€{{ order.total }}</div>
                    </div>
                </div>

                <div class="pay-methods mt-5">
                    <div class="pay-method" v-for="(method,index) in options.payment_methods" :key="index">
                        <label class="label-radio">
                            <input type="radio" class="radio" :value="method.id"
                                   @change="loadOrderData" v-model="order.payment_method"/>
                            <span class="radio-box"></span>
                            <div class="pay-method__details flex-flow-1">
                                <div>{{ method.title }}</div>
                                <div><img :src="method.img" alt=""/></div>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="mt-5">
                    <div class="invalid-feedback mb-2" :class="{'show':!!resError}" v-html="resError"></div>
                    <div class="form-group">
                        <paypal-buttons
                            :client-id="options.paypal_client_id"
                            :create-order="createPaypalOrder"
                            :on-approve="onPaypalApprove"
                            :on-click="onPaypalClick"
                            :on-error="onPaypalError"
                            v-if="order.payment_method==='online'"/>
                        <button
                            class="btn btn-block btn-bull-cyan btn-lg text-white"
                            @click="createOrder"
                            v-else
                        >Place Order
                        </button>
                    </div>
                </div>

                <p class="text-center text-safety-orange">
                    I’ve read and accept the
                    <a href="/terms-conditions" target="_blank">terms & conditions</a>
                    and <a href="/privacy" target="_blank">privacy conditions</a>
                </p>
            </div>
        </div>
        <noodle-loading v-if="loading"/>
        <noodle-dialog title="Warning" :visible="showWarning" @close="showWarning=false">
            <div class="p-4 text-center">
                <h5 class="text-safety-orange mb-5">{{options.order_warning}}</h5>
                <div>
                    <button class="btn btn-bull-cyan text-white" @click="showWarning=false">Continue</button>
                </div>
            </div>
        </noodle-dialog>
    </div>
</template>

<script>
import HttpClient from "../HttpClient";
import NoodleContainer from "../components/NoodleContainer.vue";
import PaypalButtons from "./PaypalButtons";
import CheckouItems from "./CheckouItems.vue";
import NoodleLoading from "../components/NoodleLoading.vue";
import CheckoutUsePoints from "./CheckoutUsePoints.vue";
import CheckoutShipping from "./CheckoutShipping.vue";
import NoodleOverlayer from "../components/NoodleOverlayer.vue";

export default {
    name: "NoodleCheckout",
    components: {
        NoodleOverlayer,
        CheckoutShipping,
        CheckoutUsePoints,
        NoodleLoading,
        CheckouItems,
        PaypalButtons,
        NoodleContainer
    },
    data() {
        return {
            loading: true,
            options: {
                enable_points_checkout: 'no',
                shipping_zones: [],
                payment_methods: []
            },
            order: {
                payment_method: null,
                shipping_method: 'flat_rate',
                shipping: {},
                shipping_zone_id: 0,
                items: [],
                discount_lines: [],
                fee_lines: [],
                buyer_note: '',
                subtotal: 0,
                total: 0,
                created_via: 'web',
                use_points_value: 0
            },
            resError: null,
            showWarning: false
        }
    },
    methods: {
        fetchOptions() {
            HttpClient.get('/checkout/options').then((response) => {
                this.options = {
                    ...this.options,
                    ...response.data
                };
                this.showWarning = !this.options.in_delivery_hours;
            });
        },
        createOrder() {
            this.loading = true;
            this.resError = null;
            return HttpClient.post('/orders', this.order).then((res) => {
                window.location.assign(res.data.links[0].href);
            }).catch(reason => {
                this.resError = reason.message;
                this.$showToast(reason.message);
            }).finally(() => {
                this.loading = false;
            });
        },
        onPaypalClick(data, actions) {
            let {shipping} = this.order;
            if (!shipping.first_name) {
                this.$showToast('Please fill your name');
                return actions.reject();
            }

            if (!shipping.phone_number) {
                this.$showToast('Please fill your phone number');
                return actions.reject();
            }

            if (this.order.shipping_method === 'flat_rate') {
                if (!shipping.formatted_address) {
                    this.$showToast('Please fill your address');
                    return actions.reject();
                }
            }

            return actions.resolve();
        },
        createPaypalOrder(data, actions) {
            return HttpClient.post('/payment/paypal/order', this.order).then(response => {
                return response.data.id;
            });
        },
        onPaypalApprove(data, actions) {
            //console.log(data, actions);
            this.loading = true;
            actions.order.capture().then((response) => {
                //console.log(response);
                this.order.out_trade_no = response.id;
                this.createOrder();
            });
            // return HttpClient.post(`/orders/${data.orderID}/capture`).then((response) => {
            //     window.location.assign(response.data.links[1].href);
            // }).catch((error) => {
            //     this.$showToast(error.message);
            // });
        },
        onPaypalError(error) {
            //console.log(error);
            this.$showToast(error.message);
        },
        onPointsChange(points) {
            this.order = {
                ...this.order,
                use_points_value: points
            };
            this.loadOrderData();
        },
        onShippingChange(data) {
            //console.log(data);
            this.order.shipping = data.shipping;
            if (data.shipping_zone_id !== this.order.shipping_zone_id) {
                this.order.shipping_zone_id = data.shipping_zone_id;
                this.loadOrderData();
            }
            if (data.shipping_method !== this.order.shipping_method) {
                this.order.shipping_method = data.shipping_method;
                this.loadOrderData();
            }
        },
        loadOrderData() {
            this.loading = true;
            HttpClient.post('/checkout/order', this.order).then((response) => {
                this.order = {
                    ...this.order,
                    ...response.data
                };
            }).catch((error) => {
                console.log(error.message);
            }).finally(() => {
                this.loading = false;
            });
        }
    },
    mounted() {
        this.fetchOptions();
        this.loadOrderData({});
    }
}
</script>

<style scoped>

</style>