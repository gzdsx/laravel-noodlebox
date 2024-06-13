<template>
    <noodle-container :loading="loading">
        <div class="container" v-if="cart_items.length===0">
            <h3 class="text-center pt-5 pb-5">The cart is empty!</h3>
        </div>
        <div class="container" v-else>
            <div class="checkout-body">
                <div class="checkout-col">
                    <h3 class="font-weight-bold mb-4">Billing & Shipping</h3>
                    <h5 class="font-weight-bold mb-3">Shipping Method</h5>
                    <div class="form-group row align-items-center">
                        <div class="col-8 d-flex column-gap-1 align-items-center">
                            <label class="label-radio">
                                <input type="radio" class="radio" value="delivery" v-model="shipping_method"/>
                                <span class="radio-box"></span>
                                <span class="text-safety-orange">Delivery</span>
                            </label>
                            <label class="label-radio">
                                <input type="radio" class="radio" value="collection" v-model="shipping_method"/>
                                <span class="radio-box"></span>
                                <span class="text-safety-orange">Collection</span>
                            </label>
                        </div>
                    </div>

                    <h5 class="font-weight-bold">Contact Details</h5>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="form-group__label">Your name<i>*</i></div>
                                <div class="form-group__input">
                                    <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Your name"
                                            :class="{'is-invalid':errors.name}"
                                            v-model="shipping.first_name"
                                    />
                                </div>
                                <div class="invalid-feedback" v-show="errors.name">Please enter your name</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group__label">Phone number<i>*</i></div>
                            <div class="form-group__input">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <select class="form-control" @change="onPhoneNumberChange"
                                                v-model="phone.national_number"
                                                style="border-right: 0;">
                                            <option value="353">+353</option>
                                            <option value="44">+44</option>
                                        </select>
                                    </div>
                                    <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Phone number"
                                            :class="{'is-invalid':errors.phone}"
                                            v-model="phone.phone_number"
                                            @input="onPhoneNumberChange"
                                    />
                                    <div class="input-group-append">
                                        <button class="btn btn-success" disabled v-if="phoneVerified">Verified
                                        </button>
                                        <button class="btn btn-danger" @click="showCodeInput=true" v-else>Verify
                                        </button>
                                    </div>
                                </div>
                                <div class="d-flex flex-column mt-2" v-if="showCodeInput">
                                    <div class="input-group">
                                        <input class="form-control" maxlength="6" placeholder="please enter code"
                                               v-model="verificationCode">
                                        <div class="input-group-append">
                                            <button :disabled="disabledSendCode" @click="getPhoneCode"
                                                    class="btn btn-secondary">
                                                {{ sendingCodeText }}
                                            </button>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <button type="button" :disabled="verificationCode.length!==6"
                                                class="btn btn-primary" @click="verifyPhoneNumber">Submit
                                        </button>
                                    </div>
                                </div>

                            </div>
                            <div class="invalid-feedback" v-show="errors.phone">{{ errors.phone }}</div>
                        </div>
                    </div>

                    <div class="mt-4" v-if="shipping_method==='delivery'">
                        <div class="form-group">
                            <div class="form-group__label">Address<i>*</i></div>
                            <div class="form-group__input">
                                <vue-google-autocomplete
                                        id="address"
                                        classname="form-control"
                                        placeholder="Please enter 2 or more characters"
                                        v-on:placechanged="getShippingAddress"
                                        :country="['irl']"
                                        :value="formatted_address"
                                        @change="addressChange"
                                />
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col">
                                <div class="form-group__label">Town/Area</div>
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
                                <div class="form-group__label">Eircode</div>
                                <div class="form-group__input">
                                    <input type="text" class="form-control" v-model="shipping.postal_code"/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-4">
                        <h5 class="font-weight-bold">Order notes</h5>
                        <div class="form-group__input">
                                <textarea type="text" class="form-control" rows="3" placeholder=""
                                          v-model="buyer_note"></textarea>
                        </div>
                    </div>
                </div>
                <div class="checkout-col checkout-order">
                    <h3 class="font-weight-bold">You order</h3>
                    <checkou-items :items="cart_items"/>
                    <div class="form-group mt-4" v-if="settings.enable_points_checkout==='yes'">
                        <div class="form-group__label">Use Points</div>
                        <div class="form-group__input">
                            <div class="input-group" style="width: 300px;">
                                <input type="number" class="form-control" v-model="points" @input="onInputPoints"/>
                                <div class="input-group-append">
                                    <button class="btn btn-danger" @click="points=pointsAccount.points">Use all points
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="text-turquoise mt-2">{{ pointsAccount.tips }}</div>
                    </div>
                    <div class="order-totals">
                        <div class="order-total">
                            <div class="order-total__label">Subtotal</div>
                            <div class="order-total__total">€{{ subtotal }}</div>
                        </div>
                        <div class="order-total" v-if="shippingFee">
                            <div class="order-total__label">Shipping</div>
                            <div class="order-total__total">+€{{ shippingFee }}</div>
                        </div>
                        <div class="order-total" v-if="paymentFee">
                            <div class="order-total__label">Payment</div>
                            <div class="order-total__total">+€{{ paymentFee }}</div>
                        </div>
                        <div class="order-total" v-if="points>0">
                            <div class="order-total__label">Points</div>
                            <div class="order-total__total">-€{{ pointDiscount }}</div>
                        </div>
                        <div class="order-total">
                            <div class="order-total__label">Total</div>
                            <div class="order-total__total">€{{ total }}</div>
                        </div>
                    </div>

                    <div class="pay-methods mt-5">
                        <div class="pay-method" v-for="(method,index) in payment_methods" :key="index">
                            <label class="label-radio">
                                <input type="radio" class="radio" :value="index" v-model="payment_method_index"/>
                                <span class="radio-box"></span>
                                <div class="pay-method__details flex-flow-1">
                                    <div>{{ method.description }}</div>
                                    <div><img :src="method.img" alt=""/></div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="form-group mt-5">
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
import PaypalButtons from "../checkout/PaypalButtons.vue";
import VueGoogleAutocomplete from "../../lib/VueGoogleAutocomplete.vue";
import CartService from "../CartService";
import CheckouItems from "../checkout/CheckouItems.vue";

let controller = new AbortController();
const cart = new CartService();
export default {
    name: "LotteryCheckout",
    components: {CheckouItems, PaypalButtons, NoodleContainer, VueGoogleAutocomplete},
    data() {
        return {
            cart_items: [],
            address_list: [],
            payment_method_index: 0,
            shipping_method: 'delivery',
            shipping_zones: [],
            shipping_zone_index: 0,
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
            loading: false,
            formatted_address: '',
            phone: {
                national_number: '353',
                phone_number: '',
                verified: false
            },
            original_phone: {
                national_number: '353',
                phone_number: '',
                verified: false
            },
            showCodeInput: false,
            verificationCode: '',
            phoneVerified: false,
            sendingCodeText: 'Get Code',
            sendingCode: false,
            points: 0,
            pointsAccount: {
                'points': 0,
                'exchange_rate': 1,
                'tips': ''
            },
            settings: {
                enable_points_checkout: 'no'
            }
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
            return (parseFloat(this.subtotal) + parseFloat(this.shippingFee) + parseFloat(this.paymentFee) - parseFloat(this.pointDiscount)).toFixed(2);
        },
        disabledSendCode() {
            return this.phone.phone_number.length < 5 || this.sendingCode;
        },
        pointDiscount() {
            if (this.points > 0) {
                return (Number(this.points) * Number(this.pointsAccount.exchange_rate)).toFixed(2);
            }

            return 0;
        }
    },
    watch: {},
    methods: {
        async fetchData() {
            let response = await HttpClient.get('/users/addresses');
            const {shipping} = response.data;
            this.fillShipping(shipping);

            response = await HttpClient.get('/shipping-zones');
            this.shipping_zones = response.data.items;
            this.shipping_zones.map((s, i) => {
                if (s.title === shipping.city) {
                    this.shipping_zone_index = i;
                }
            });
        },
        validateOrder() {
            let check = true;
            let {cart_items, shipping_method, shipping, buyer_note} = this;

            if (!shipping.first_name) {
                //this.errors.name = 'Please enter your name';
                this.$showToast('Please enter your name');
                return false;
            }

            if (!shipping.phone) {
                //this.errors.phone = 'Please enter your phone number';
                this.$showToast('Please enter your phone number');
                return false;
            }

            if (shipping_method === 'delivery') {
                if (!shipping.address_line_1) {
                    //this.errors.address = 'Please enter your address';
                    this.$showToast('Please enter your address');
                    return false;
                }
            }

            if (!this.phoneVerified) {
                this.$showToast('Please verify your phone number');
                return false;
            }

            return check;
        },
        createOrder() {
            let {cart_items, shipping_method, shipping, buyer_note} = this;

            if (!this.validateOrder()) {
                return false;
            }

            let shipping_zone_id = 0;
            if (shipping_method === 'delivery') {
                let zone = this.shipping_zones[this.shipping_zone_index];
                shipping_zone_id = zone.id;
                this.shipping.city = zone.title;
            }

            let fee_lines = [];
            let payment_method = '', payment_method_title = '';
            let method = this.payment_methods[this.payment_method_index];
            if (method) {
                if (method.fee) {
                    fee_lines.push({
                        name: 'Payment',
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
                    meta_data: item.options,
                    subtotal: item.subtotal,
                    total: item.subtotal,
                    use_point_purchase: item.usePointPurchase,
                    point_price: item.point_price
                }
            });

            let meta_data = [];
            if (this.points > 0) {
                meta_data.push({
                    key: 'cost_points',
                    value: this.points
                });
            }

            this.loading = false;
            shipping.phone = this.phone;
            return HttpClient.post('/orders', {
                shipping_method,
                shipping_zone_id,
                shipping,
                buyer_note,
                payment_method,
                payment_method_title,
                fee_lines,
                discount_lines,
                billing: shipping,
                items: order_items,
                meta_data,
                points: this.points
            }).then((res) => {
                cart.clearCart();
                window.location.assign(res.data.links[1].href);
            }).catch(reason => {
                console.log(reason.message);
            }).finally(() => {
                this.loading = false;
            });
        },
        createPaypalOrder(data, actions) {
            //console.log(actions);
            if (!this.validateOrder()) {
                return Promise.reject();
            }
            let {total, shipping, cart_items, subtotal, shippingFee, paymentFee} = this;
            let items = cart_items.map((item) => {
                return {
                    name: item.title,
                    unit_amount: {
                        currency_code: 'EUR',
                        value: item.price
                    },
                    quantity: item.quantity,
                    //sku: item.id,
                    //image_url: item.image,
                }
            });
            return HttpClient.post('/payment/paypal/create-order', {
                orderData: {
                    intent: 'CAPTURE',
                    purchase_units: [
                        {
                            amount: {
                                value: total.toString(),
                                currency_code: 'EUR',
                                breakdown: {
                                    item_total: {
                                        currency_code: 'EUR',
                                        value: subtotal.toString()
                                    },
                                    shipping: {
                                        currency_code: 'EUR',
                                        value: shippingFee.toString()
                                    },
                                    handling: {
                                        currency_code: 'EUR',
                                        value: paymentFee.toString()
                                    }
                                }
                            },
                            items,
                        }
                    ],
                    payment_source: {
                        // card: {
                        //     number: '4111111111111111',
                        //     expiry: '01/2023',
                        //     cvv: '123',
                        //     name: 'John Doe',
                        //     billing_address: {
                        //         address_line_1: '123 Main St',
                        //         address_line_2: 'Apt 2',
                        //         admin_area_2: 'San Francisco',
                        //         admin_area_1: 'CA',
                        //         postal_code: '94105',
                        //         country_code: 'US'
                        //     }
                        // },
                        paypal: {
                            email_address: '',
                            name: {
                                given_name: shipping.first_name,
                                surname: shipping.last_name
                            },
                            address: {
                                address_line_1: shipping.address_line_1,
                                address_line_2: shipping.address_line_2,
                                admin_area_2: shipping.city,
                                admin_area_1: shipping.state,
                                postal_code: shipping.postalcode,
                                country_code: 'IR'
                            },
                            // phone: {
                            //     phone_type: 'MOBILE',
                            //     phone_number: {
                            //         national_number: ''
                            //     },
                            // },
                            experience_context: {
                                brand_name: 'Noodlebox',
                                landing_page_type: 'LOGIN',
                                user_action: 'PAY_NOW',
                                //return_url: 'https://example.com/return',
                                //cancel_url: 'https://example.com/cancel',
                            }
                        }
                    },
                }
            }).then(response => {
                return response.data.id;
            });
        },
        metaValue(options) {
            return Object.values(options).join(',');
        },
        getShippingAddress(addressData, placeResultData, id) {
            console.log(addressData);
            console.log(placeResultData);
            const {
                subpremise,
                street_number,
                route,
                locality,
                country,
                postal_code,
                postal_code_prefix,
                neighborhood,
                administrative_area_level_1,
                administrative_area_level_2
            } = addressData;

            const {formatted_address, address_components} = placeResultData;

            let check = false;
            this.shipping_zones.map((s, i) => {
                if (formatted_address.indexOf(s.title) !== -1) {
                    check = true;
                    this.shipping_zone_index = i;
                    this.shipping.city = s.title;
                    this.$forceUpdate();
                }
            });

            if (!check) {
                this.$showToast(`This address is not within the delivery range`);
                this.formatted_address = '';
                return false;
            }

            if (country) {
                this.shipping.country = country;
            }

            if (administrative_area_level_1) {
                this.shipping.state = administrative_area_level_1;
            }

            // if (locality) {
            //     this.shipping.city = locality;
            // } else {
            //     this.shipping.city = neighborhood;
            // }

            if (postal_code) {
                this.shipping.postal_code = postal_code;
            } else {
                this.shipping.postal_code = postal_code_prefix;
            }

            let address = '', sp = '';
            if (subpremise) {
                address += sp + subpremise;
                sp = ' ';
            }
            if (street_number) {
                address += sp + street_number;
                sp = ' ';
            }
            if (route) {
                address += sp + route;
            }

            if (neighborhood) {
                address += ',' + neighborhood;
            }

            this.shipping.address_line_1 = address;
            this.$forceUpdate();
        },
        addressChange(v) {
            console.log('change');
            this.shipping.address_line_1 = v;
            // this.shipping.address_line_2 = '';
            // this.shipping.county = '';
            // this.shipping.city = '';
            // this.shipping.state = '';
            // this.shipping.postalcode = '';
        },
        fillShipping(address) {
            this.shipping = {
                ...this.shipping,
                first_name: address.first_name,
                last_name: address.last_name,
                email: address.email,
                country: address.country,
                state: address.state,
                city: address.city,
                county: address.county,
                address_line_1: address.address_line_1,
                address_line_2: address.address_line_2,
                postal_code: address.postal_code,
            };

            if (address.phone) {
                let {national_number, phone_number, verified} = address.phone;
                if (national_number) {
                    this.phone.national_number = national_number;
                }

                if (phone_number) {
                    this.phone.phone_number = phone_number;
                }

                this.phone.verified = verified ? verified : false;
                this.original_phone = {
                    national_number,
                    phone_number,
                    verified
                };
                this.phoneVerified = verified ? verified : false;
            }

            let addressline = address.address_line_1;
            if (address.city) {
                addressline += ',' + address.city;
            }

            if (address.state) {
                addressline += ',' + address.state;
            }
            if (address.country) {
                addressline += ',' + address.country;
            }
            this.formatted_address = addressline;

            //console.log(address);

        },
        onPhoneNumberChange() {
            let {
                national_number,
                phone_number,
                verified
            } = this.phone;

            if (phone_number === this.original_phone.phone_number && national_number === this.original_phone.national_number) {
                this.phoneVerified = this.original_phone.verified;
                return;
            }

            if (controller) {
                controller.abort();
                controller = new AbortController();
            }

            HttpClient.post('phones/check', {
                phone_number,
                national_number
            }, {
                signal: controller.signal
            }).then(response => {
                this.phoneVerified = response.data;
            }).catch((e) => {
                console.log(e);
            });
        },
        getPhoneCode() {
            let {phone_number, national_number} = this.phone;
            if (this.sendingCode) {
                return false;
            } else {
                this.sendingCode = true;
            }

            var that = this;
            HttpClient.post('/sms/send', {
                phone_number,
                national_number
            }).then(response => {
                this.$showToast('SMS have sned!');
                let timer = 60;
                let interval = setInterval(() => {
                    timer--;
                    this.sendingCode = timer > 0;
                    if (timer === 0) {
                        clearInterval(interval);
                    }
                    that.sendingCodeText = timer > 0 ? 'Retrive after ' + timer + 's' : 'Get Code';
                }, 1000);
            }).catch(e => {
                console.log(e);
                this.$showToast(e.message);
            });
        },
        verifyPhoneNumber() {
            let {phone_number, national_number} = this.phone;
            HttpClient.post('/phones/verify', {
                phone_number,
                national_number,
                vercode: this.verificationCode
            }).then(response => {
                this.$showToast('Phone number verified!');
                this.phoneVerified = true;
                this.showCodeInput = false;
            }).catch(e => {
                console.log(e);
                this.$showToast(e.message);
            });
        },
        fetchPointsAccount() {
            HttpClient.get('/my/points').then((response) => {
                this.pointsAccount = response.data;
            });
        },
        onInputPoints(e) {
            this.points = this.points.replace(/[^0-9]/g, '');
            if (this.points > this.pointsAccount.points) {
                this.points = this.pointsAccount.points;
            }
        },
        fetchCheckoutSettings() {
            HttpClient.get('/checkout/settings').then((response) => {
                this.settings = {
                    ...this.settings,
                    ...response.data
                };
            });
        },
        fetchCartItems() {
            this.loading = true;
            HttpClient.get('/lottery/carts').then((res) => {
                this.cart_items = res.data.items.map(item => {
                    let {name, image, quantity} = item;
                    return {
                        title:name,
                        image,
                        quantity,
                        price: 0,
                        subtotal: 0,
                        total: 0,
                    }
                });
            }).finally(() => {
                this.loading = false;
            });
        },
    },
    mounted() {
        this.fetchCartItems();
        this.fetchData();
        this.fetchPointsAccount();
        this.fetchCheckoutSettings();
    }
}
</script>

<style scoped>

</style>