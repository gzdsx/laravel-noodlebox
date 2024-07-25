<template>
    <div>
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
                            <select class="form-control"
                                    @change="checkPhoneNumber"
                                    v-model="shipping.national_number"
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
                            @change="checkPhoneNumber"
                            v-model="shipping.phone_number"
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
                            <input class="form-control"
                                   maxlength="6"
                                   placeholder="please enter code"
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

        <h5 class="font-weight-bold mb-3">Shipping Method</h5>
        <div class="form-group row align-items-center">
            <div class="col-8 d-flex column-gap-1 align-items-center">
                <label class="label-radio">
                    <input type="radio" class="radio"
                           value="flat_rate"
                           @change="onTotalChange"
                           v-model="shipping_method"/>
                    <span class="radio-box"></span>
                    <span class="text-safety-orange">Delivery</span>
                </label>
                <label class="label-radio">
                    <input type="radio" class="radio"
                           value="local_pickup"
                           @change="onTotalChange"
                           v-model="shipping_method"/>
                    <span class="radio-box"></span>
                    <span class="text-safety-orange">Collection</span>
                </label>
            </div>
        </div>

        <div class="mt-4" v-if="shipping_method==='flat_rate'">
            <div class="form-group">
                <div class="form-group__label">Address<i>*</i></div>
                <div class="form-group__input">
                    <vue-google-autocomplete
                        id="address"
                        classname="form-control"
                        placeholder="Please enter 2 or more characters"
                        v-on:placechanged="getShippingAddress"
                        :country="['irl']"
                        :value="shipping.formatted_address"
                        @change="addressChange"
                    />
                </div>
            </div>

            <div class="form-group row">
                <div class="col">
                    <div class="form-group__label">Town/Area</div>
                    <div class="form-group__input">
                        <select class="form-control custom-select"
                                @change="onTotalChange"
                                v-model="shipping_zone_id">
                            <option v-for="(zone,index) in shippingZones" :key="index" :value="zone.id">
                                {{ zone.title + ' €' + zone.fee }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group__label">Eircode</div>
                    <div class="form-group__input">
                        <input type="text"
                               class="form-control"
                               v-model="shipping.postal_code"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import HttpClient from "../HttpClient";
import VueGoogleAutocomplete from "../../lib/VueGoogleAutocomplete.vue";

let controller = new AbortController();
export default {
    name: "CheckoutShipping",
    components: {VueGoogleAutocomplete},
    props: {
        errors: {
            type: Object,
            default: () => {
                return {}
            }
        },
        order: {
            type: Object,
            default: () => {
                return {}
            }
        },
        shippingZones: {
            type: Array,
            default: () => {
                return []
            }
        },
    },
    watch: {
        'shipping': {
            handler(newVal) {
                this.onShippingChange();
            },
            deep: true
        },
        'shipping_method': {
            handler(newVal) {
                this.onShippingChange();
            }
        },
        'shipping_zone_id': {
            handler(newVal) {
                this.onShippingChange();
            }
        },
        'order':{
            handler(newVal) {
                this.shipping = {
                    ...this.shipping,
                    ...newVal.shipping
                };
                this.shipping_method = newVal.shipping_method;
                this.shipping_zone_id = newVal.shipping_zone_id;
                this.checkPhoneNumber();
            }
        }
    },
    data() {
        return {
            shipping: {
                first_name: '',
                national_number: '353',
                phone_number: '',
                formatted_address: '',
                postal_code: ''
            },
            shipping_method: 'flat_rate',
            shipping_zone_id: 0,
            phoneVerified: false,
            showCodeInput: false,
            verificationCode: '',
            sendingCodeText: 'Send code',
            disabledSendCode: false,
        }
    },
    methods: {
        checkPhoneNumber() {
            let {national_number, phone_number} = this.shipping;
            if (controller) {
                controller.abort();
                controller = new AbortController();
            }

            if (phone_number && national_number) {
                HttpClient.post('/my/phones/check', {
                    phone_number,
                    national_number
                }, {
                    signal: controller.signal
                }).then(response => {
                    this.phoneVerified = response.data;
                    this.showCodeInput = false;
                }).catch((e) => {
                    console.log(e);
                });
            }
        },
        verifyPhoneNumber() {
            let {phone_number, national_number} = this.shipping;
            HttpClient.post('/my/phones/verify', {
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
        getPhoneCode() {
            let {phone_number, national_number} = this.shipping;
            if (this.sendingCode) {
                return false;
            } else {
                this.sendingCode = true;
            }

            let that = this;
            HttpClient.post('/captcha/sms', {
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
        getShippingAddress(addressData, placeResultData, id) {
            // console.log(addressData);
            // console.log(placeResultData);
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

            const {formatted_address} = placeResultData;
            const check = this.shippingZones.some(s => formatted_address.indexOf(s.title) !== -1);
            if (!check) {
                this.$showToast('The address is not within the delivery range');
                this.shipping.formatted_address = '';
                return false;
            }

            this.shippingZones.map((s, i) => {
                if (formatted_address.indexOf(s.title) !== -1) {
                    this.shipping_zone_id = s.id;
                }
            });

            if (country) {
                this.shipping.country = country;
            }

            if (administrative_area_level_1) {
                this.shipping.state = administrative_area_level_1;
            }

            if (locality) {
                this.shipping.city = locality;
            } else {
                this.shipping.city = neighborhood;
            }

            if (postal_code) {
                this.shipping.postal_code = postal_code;
            } else {
                this.shipping.postal_code = postal_code_prefix;
            }

            let addressline = '', sp = '';
            if (subpremise) {
                addressline += sp + subpremise;
                sp = ' ';
            }
            if (street_number) {
                addressline += sp + street_number;
                sp = ' ';
            }
            if (route) {
                addressline += sp + route;
            }

            if (neighborhood) {
                addressline += ',' + neighborhood;
            }

            this.shipping.address_1 = addressline;
            this.shipping.formatted_address = formatted_address;
            this.$forceUpdate();
        },
        addressChange(v) {
            this.shipping.formatted_address = v;
        },
        onTotalChange() {
            this.$emit('total-change', this.order);
        },
        onShippingChange() {
            const {shipping, shipping_zone_id, shipping_method} = this;
            this.$emit('change', {
                shipping,
                shipping_zone_id,
                shipping_method
            });
        },
    },
    mounted() {
        this.checkPhoneNumber();
    }
}
</script>

<style scoped>

</style>