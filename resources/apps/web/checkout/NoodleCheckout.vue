<template>
    <div class="container">
        <div class="checkout-body">
            <div class="checkout-col">
                <checkout-shipping @change="onShippingChange" @zone-change="loadOrderData"/>
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
                <div class="form-group mt-4" v-if="settings.enable_points_checkout==='yes'">
                    <checkout-use-points :subtotal="order.subtotal" @change="onPointsChange"/>
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
                    <div class="pay-method" v-for="(method,index) in payment_methods" :key="index">
                        <label class="label-radio">
                            <input type="radio" class="radio" :value="index" v-model="payment_method_index"/>
                            <span class="radio-box"></span>
                            <div class="pay-method__details flex-flow-1">
                                <div>{{ method.title }}</div>
                                <div><img :src="method.img" alt=""/></div>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="mt-5">
                    <div class="invalid-feedback" v-if="resError" v-html="resError"></div>
                    <div class="form-group">
                        <paypal-buttons
                                :create-order="createPaypalOrder"
                                :on-approve="createOrder"
                                v-if="payment_method_index===0"/>
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
import CartService from "../CartService";
import CheckouItems from "./CheckouItems.vue";
import NoodleLoading from "../components/NoodleLoading.vue";
import CheckoutUsePoints from "./CheckoutUsePoints.vue";
import CheckoutShipping from "./CheckoutShipping.vue";

let controller = new AbortController();
const cart = new CartService();
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
            payment_methods: [
                {
                    id: 'online',
                    title: 'Pay Online (PayPal & Credit Car)',
                    fee: 0.5,
                    img: '/images/noodlebox/Full_Online.png'
                },
                {
                    id: 'card',
                    title: 'Pay by Card Reader',
                    fee: 0.5,
                    img: '/images/noodlebox/pay_by_card.png'
                },
                {
                    id: 'cash',
                    title: 'Pay Cash',
                    fee: 0.0,
                    img: '/images/noodlebox/pay_cash.png'
                },
            ],
            payment_method_index: 0,
            settings: {
                enable_points_checkout: 'no'
            },
            order: {
                payment_method: 'online',
                payment_method_title: 'Pay Online (PayPal & Credit Car)',
                shipping_line: {
                    method_id: '',
                    method_title: '',
                    zone_id: '',
                    zone_title: '',
                },
                shipping: {
                    first_name: '',
                    last_name: '',
                    phone: {
                        national_number: '353',
                        phone_number: ''
                    },
                    email: '',
                    address_line_1: '',
                    address_line_2: '',
                    county: '',
                    city: '',
                    state: '',
                    country: '',
                    postal_code: '',
                },
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
    watch: {
        payment_method_index(val) {
            let method = this.payment_methods[val];
            this.order.payment_method = method.id;
            this.order.payment_method_title = method.title;
            this.loadOrderData();
        }
    },
    methods: {
        fetchCheckoutSettings() {
            HttpClient.get('/checkout/settings').then((response) => {
                this.settings = {
                    ...this.settings,
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
            return HttpClient.post('/payment/paypal/create-order', this.order).then(response => {
                return response.data.id;
            });
        },
        onPointsChange(data) {
            this.order.meta_data['use_points_value'] = data.points;
            this.loadOrderData();
        },
        onShippingChange(data) {
            let {shipping, shipping_line} = data;
            this.order = {
                ...this.order,
                shipping,
                shipping_line
            }
        },
        loadOrderData() {
            this.loading = true;
            HttpClient.post('/checkout/order', this.order).then((response) => {
                this.order = {
                    ...this.order,
                    ...response.data
                };
                this.settings = {
                    ...this.settings,
                    ...response.data.settings
                };
            }).catch((error) => {
                console.log(error.message);
            }).finally(() => {
                this.loading = false;
            });
        }
    },
    mounted() {

    }
}
</script>

<style scoped>

</style>