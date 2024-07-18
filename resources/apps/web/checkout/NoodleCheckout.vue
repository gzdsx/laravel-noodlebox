<template>
    <div class="container">
        <div class="checkout-body">
            <div class="checkout-col">
                <checkout-shipping
                    :order.sync="order"
                    :shipping-zones.sync="options.shipping_zones"
                    @total-change="loadOrderData"
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
                    <checkout-use-points :default-points.sync="order.meta_data.use_points_value||0"
                                         @submit="onPointsChange"/>
                </div>
                <div class="order-totals">
                    <div class="order-total">
                        <div class="order-total__label">Subtotal</div>
                        <div class="order-total__total">€{{ order.subtotal }}</div>
                    </div>
                    <div class="order-total" v-if="order.shipping_line.method_id === 'flat_rate'">
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
                    <div class="invalid-feedback show" v-if="resError" v-html="resError"></div>
                    <div class="form-group">
                        <paypal-buttons
                            :create-order="createPaypalOrder"
                            :on-approve="createOrder"
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
                    I’ve read and accept the <a>terms & conditions</a> and <a>privacy conditions</a></p>
            </div>
        </div>
        <noodle-loading v-if="loading"/>
    </div>
</template>

<script>
import HttpClient from "../HttpClient";
import NoodleContainer from "../components/NoodleContainer.vue";
import PaypalButtons from "./PaypalButtons.vue";
import CheckouItems from "./CheckouItems.vue";
import NoodleLoading from "../components/NoodleLoading.vue";
import CheckoutUsePoints from "./CheckoutUsePoints.vue";
import CheckoutShipping from "./CheckoutShipping.vue";

export default {
    name: "NoodleCheckout",
    components: {
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
                payment_method: 'online',
                payment_method_title: 'Pay Online (PayPal & Credit Car)',
                shipping_method: 'flat_rate',
                shipping: {},
                shipping_line: {},
                items: [],
                meta_data: {},
                buyer_note: '',
                subtotal: 0,
                total: 0,
                created_via: 'checkout'
            },
            resError: null
        }
    },
    methods: {
        fetchOptions() {
            HttpClient.get('/checkout/options').then((response) => {
                this.options = {
                    ...this.options,
                    ...response.data
                };
            });
        },
        createOrder() {
            this.loading = true;
            return HttpClient.post('/orders', this.order).then((res) => {
                window.location.assign(res.data.links[1].href);
            }).catch(reason => {
                this.resError = reason.message;
                this.$showToast(reason.message);
            }).finally(() => {
                this.loading = false;
            });
        },
        createPaypalOrder(data, actions) {
            return HttpClient.post('/payment/paypal/order', this.order).then(response => {
                return response.data.id;
            });
        },
        onPaypalClick(data, actions) {
            let {shipping} = this.order;
            if (!shipping.first_name) {
                this.$showToast('Please fill your name');
                return actions.reject();
            }

            if (!shipping.phone.phone_number) {
                this.$showToast('Please fill your phone number');
                return actions.reject();
            }

            if (!shipping.address_line_1) {
                this.$showToast('Please fill your address');
                return actions.reject();
            }

            //console.log(shipping);
            if (!shipping.phone.verified) {
                this.$showToast('Phone number not verified');
                return actions.reject();
            }

            return actions.resolve();
        },
        onPaypalError(error) {
            //console.log(error);
            this.$showToast(error.message);
        },
        onPointsChange(points) {
            this.order.meta_data = {
                ...this.order.meta_data,
                use_points_value: points
            };
            this.loadOrderData();
        },
        onShippingChange(shipping) {
            this.order.shipping = shipping;
        },
        onShippingLineChange(shipping_line) {
            console.log(shipping_line);
            this.order.shipping_line = shipping_line;
            this.loadOrderData();
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