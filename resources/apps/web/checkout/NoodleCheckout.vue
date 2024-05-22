<template>
    <noodle-container :loading="loading">
        <div class="container">
            <div class="checkout-body">
                <div class="checkout-col">
                    <h3 class="font-weight-bold">Billing & Shipping</h3>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-group__label">Your name<i>*</i></div>
                                    <div class="form-group__input">
                                        <input type="text" class="form-control" placeholder="Your name"
                                               v-model="shipping.first_name"/>
                                    </div>
                                    <div class="invalid-feedback" v-show="errors.name">Please enter your name</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group__label">Phone number<i>*</i></div>
                                <div class="form-group__input">
                                    <input type="text" class="form-control" placeholder="Phone number"
                                           v-model="shipping.phone"/>
                                </div>
                                <div class="invalid-feedback" v-show="errors.phone">Please enter your phone number</div>
                            </div>
                        </div>
                    </div>
                    <div class="checkout-section">
                        <h5 class="font-weight-bold flex-grow-1">Shipping options</h5>
                        <div class="d-flex column-gap-1 align-items-center">
                            <label class="label-radio">
                                <input type="radio" class="radio" value="delivery" v-model="shipping_method"/>
                                <span class="radio-box"></span>
                                <span>Delivery</span>
                            </label>
                            <label class="label-radio">
                                <input type="radio" class="radio" value="collection" v-model="shipping_method"/>
                                <span class="radio-box"></span>
                                <span>Collection</span>
                            </label>
                        </div>
                    </div>
                    <div v-if="shipping_method==='delivery'">
                        <div class="form-group row">
                            <div class="col">
                                <div class="form-group__label">Town / Area</div>
                                <div class="form-group__input">
                                    <select class="form-control custom-select" v-model="shipping_zone_index">
                                        <option v-for="(zone,index) in shipping_zones" :key="index" :value="index">{{
                                            zone.title + ' €' + zone.fee
                                            }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group__label">Country/Region</div>
                                <div class="form-group__input">
                                    <h3 class="text-safety-orange">Ireland</h3>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-group__label">Street address<i>*</i></div>
                            <div class="form-group__input">
                                <input type="text" class="form-control" placeholder="Please Enter .."
                                       v-model="shipping.address_line_1"/>
                            </div>
                            <div class="invalid-feedback" v-show="errors.address">Please enter your street address</div>
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                <div class="form-group__label">Order notes</div>
                                <div class="form-group__input">
                                <textarea type="text" class="form-control" rows="3" placeholder=""
                                          v-model="buyer_note"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="checkout-col checkout-order">
                    <h3 class="font-weight-bold">You order</h3>
                    <div class="order-items">
                        <div class="order-item">
                            <div class="order-item__product order-item__header">Product</div>
                            <div class="order-item__subtotal order-item__header">Subtotal</div>
                        </div>
                        <div class="order-item" v-for="(item,index) in cart_items" :key="index">
                            <div class="order-item__product">
                                <div class="title">{{ item.title }} x {{ item.quantity }}</div>
                                <div class="additional">
                                    {{ metaValue(item.options) }}
                                </div>
                            </div>
                            <div class="order-item__subtotal">€{{ item.subtotal }}</div>
                        </div>
                    </div>
                    <div class="order-totals">
                        <div class="order-total">
                            <div class="order-total__label">Subtotal</div>
                            <div class="order-total__total">€{{ subtotal }}</div>
                        </div>
                        <div class="order-total" v-if="shippingFee">
                            <div class="order-total__label">Shipping Fee</div>
                            <div class="order-total__total">€{{ shippingFee }}</div>
                        </div>
                        <div class="order-total" v-if="paymentFee">
                            <div class="order-total__label">Payment Fee</div>
                            <div class="order-total__total">€{{ paymentFee }}</div>
                        </div>
                        <div class="order-total">
                            <div class="order-total__label">Total</div>
                            <div class="order-total__total">€{{ total }}</div>
                        </div>
                    </div>
                    <div class="pay-methods">
                        <div class="pay-method" v-for="(method,index) in payment_methods" :key="index">
                            <label class="label-radio">
                                <input type="radio" class="radio" :value="index" v-model="payment_method_index"/>
                                <span class="radio-box"></span>
                            </label>
                            <div class="pay-method__details">
                                <div>{{ method.description }}</div>
                                <div><img :src="method.img" alt=""/></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-5">
                        <paypal-buttons v-if="payment_method_index===0"/>
                        <button
                                class="btn btn-block btn-bull-cyan btn-lg text-white"
                                @click="submitOrder"
                                v-else
                        >Place Order
                        </button>
                    </div>

                    <p class="text-center text-safety-orange">
                        I’ve read and accept the <a>terms & conditions</a> and <a>privacy conditions</a></p>
                </div>
            </div>
        </div>
    </noodle-container>
</template>

<script>
import HttpClient from "../HttpClient";
import NoodleContainer from "../components/NoodleContainer.vue";
import PaypalButtons from "./PaypalButtons.vue";
import CartService from "../CartService";

const cart = new CartService();
export default {
    name: "NoodleCheckout",
    components: {PaypalButtons, NoodleContainer},
    data() {
        return {
            cart_items: [],
            payment_method_index: 0,
            shipping_method: 'delivery',
            shipping_zones: [],
            shipping_zone_index: 0,
            shipping: {
                first_name: '',
                last_name: '',
                phone: '',
                email: '',
                address_line_1: '',
                address_line_2: '',
                county: '',
                city: '',
                state: '',
                country: '',
                postalcode: '',
            },
            buyer_note: '',
            payment_methods: [
                {
                    id: 'paypal',
                    name: 'PayPal',
                    description: 'Pay Online (PayPal & Credit Car)',
                    fee: 0.5,
                    img: '/images/noodlebox/Full_Online.png'
                },
                {
                    id: 'card',
                    name: 'Card',
                    description: 'Pay by Card Reader',
                    fee: 0.5,
                    img: '/images/noodlebox/pay_by_card.png'
                },
                {
                    id: 'cash',
                    name: 'Cash',
                    description: 'Pay Cash',
                    fee: 0.00,
                    img: '/images/noodlebox/pay_cash.png'
                },
            ],
            errors: {
                name: null,
                phone: null,
                address: null,
                message: null
            },
            loading: false
        }
    },
    computed: {
        subtotal() {
            let total = 0;
            this.cart_items.forEach((item) => {
                total += parseFloat(item.subtotal);
            });
            return total.toFixed(2);
        },
        shippingFee() {
            if (this.shipping_method === 'delivery' && this.shipping_zones.length) {
                return this.shipping_zones[this.shipping_zone_index].fee;
            }

            return 0;
        },
        paymentFee() {
            let method = this.payment_methods[this.payment_method_index];
            return method.fee;
        },
        total() {
            return parseFloat(this.subtotal) + parseFloat(this.shippingFee) + parseFloat(this.paymentFee);
        },
    },
    methods: {
        fetchZones() {
            HttpClient.get('/shipping-zones').then((res) => {
                this.shipping_zones = res.data.items;
            }).catch(reason => {

            }).finally(() => {

            });
        },
        fetchAddress() {
            HttpClient.get('/users/addresses/0').then((res) => {
                const address = res.data;
                this.shipping = {
                    first_name: address.first_name,
                    last_name: address.last_name,
                    phone: address.phone,
                    country: address.country,
                    state: address.state,
                    city: address.city,
                    county: address.county,
                    address_line_1: address.address_line_1,
                    address_line_2: address.address_line_2,
                    postalcode: address.postalcode,
                };
            }).catch(reason => {

            }).finally(() => {

            });
        },
        submitOrder() {
            let {cart_items, shipping_method, shipping, buyer_note} = this;

            if (!shipping.first_name) {
                this.errors.name = 'Please enter your name';
                return false;
            } else {
                this.errors.name = null;
            }

            if (!shipping.phone) {
                this.errors.phone = 'Please enter your phone number';
                return false;
            } else {
                this.errors.phone = null;
            }

            let shipping_zone_id = 0;
            if (shipping_method === 'delivery') {
                let zone = this.shipping_zones[this.shipping_zone_index];
                shipping_zone_id = zone.id;
                shipping.county = zone.title;

                if (!shipping.address_line_1) {
                    this.errors.address = 'Please enter your address';
                    return false;
                } else {
                    this.errors.address = null;
                }
            }

            let fee_lines = [];
            let payment_method = '', payment_method_title = '';
            let method = this.payment_methods[this.payment_method_index];
            if (method) {
                if (method.fee) {
                    fee_lines.push({
                        name: 'Payment Fee',
                        total: 0.5,
                        total_tax: 0
                    });
                }
                payment_method = method.id;
                payment_method_title = method.name;
            }

            let discount_lines = [];
            let order_items = cart_items.map((item) => {
                return {
                    product_id: item.product_id,
                    quantity: item.quantity,
                    title: item.title,
                    price: item.price,
                    image: item.image,
                    meta_data: item.options
                }
            });

            this.loading = true;
            HttpClient.post('/orders', {
                shipping_method,
                shipping_zone_id,
                shipping,
                buyer_note,
                payment_method,
                payment_method_title,
                fee_lines,
                discount_lines,
                order_items,
                billing: shipping
            }).then((res) => {
                window.location.assign(res.data.approval_url);
            }).catch(reason => {

            }).finally(() => {
                this.loading = false;
            });
        },
        metaValue(options) {
            return Object.values(options).join(',');
        },
    },
    mounted() {
        this.cart_items = cart.getCartItems();
        this.fetchZones();
        this.fetchAddress();
    }
}
</script>

<style scoped>

</style>