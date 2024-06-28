<template>
    <div>
        <h3 class="font-weight-bold mb-4">Billing & Shipping</h3>
        <h5 class="font-weight-bold mb-3">Shipping Method</h5>
        <div class="form-group row align-items-center">
            <div class="col-8 d-flex column-gap-1 align-items-center">
                <label class="label-radio">
                    <input type="radio" class="radio" value="flat_rate" v-model="shipping_line.method_id"/>
                    <span class="radio-box"></span>
                    <span class="text-safety-orange">Delivery</span>
                </label>
                <label class="label-radio">
                    <input type="radio" class="radio" value="local_pickup" v-model="shipping_line.method_id"/>
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
                                @change="onChange"
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
                            <select class="form-control" @change="checkPhoneNumber"
                                    v-model="shipping.phone.national_number"
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
                                v-model="shipping.phone.phone_number"
                                @input="checkPhoneNumber"
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

        <div class="mt-4" v-if="shipping_line.method_id==='flat_rate'">
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
                        <select class="form-control custom-select" @change="onZoneChange" v-model="shipping_zone_index">
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
                        <input type="text" class="form-control" @change="onChange" v-model="shipping.postal_code"/>
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
    data() {
        return {
            shipping_line: {
                method_id: 'flat_rate',
                method_title: 'Delivery',
                zone_id: '',
                zone_title: '',
                total: 0
            },
            shipping: {
                first_name: '',
                last_name: '',
                address_line_1: '',
                address_line_2: '',
                city: '',
                postal_code: '',
                country: 'Ireland',
                state: '',
                phone: {
                    national_number: '353',
                    phone_number: '',
                },
            },
            phoneVerified: false,
            showCodeInput: false,
            verificationCode: '',
            sendingCodeText: 'Send code',
            disabledSendCode: false,
            shipping_zones: [],
            shipping_zone_index: 0,
            errors: {},
            formatted_address: '',
        }
    },
    watch: {
        shipping_line(val){
            this.onChange();
        }
    },
    methods: {
        checkPhoneNumber() {
            let {national_number, phone_number} = this.shipping.phone;
            if (controller) {
                controller.abort();
                controller = new AbortController();
            }

            HttpClient.post('/my/phones/check', {
                phone_number,
                national_number
            }, {
                signal: controller.signal
            }).then(response => {
                this.phoneVerified = response.data;
            }).catch((e) => {
                console.log(e);
            });
            this.onChange();
        },
        verifyPhoneNumber() {
            let {phone_number, national_number} = this.shipping.phone;
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
            let {phone_number, national_number} = this.shipping.phone;
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

            const {formatted_address, address_components} = placeResultData;

            this.shipping_zones.map((s, i) => {
                if (formatted_address.indexOf(s.title) !== -1) {
                    this.shipping_zone_index = i;
                    this.shipping.city = s.title;
                    this.$forceUpdate();
                }
            });

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

            this.shipping.address_line_1 = addressline;
            this.$forceUpdate();
        },
        addressChange(v) {
            //console.log('change');
            this.shipping.address_line_1 = v;
            // this.shipping.address_line_2 = '';
            // this.shipping.county = '';
            // this.shipping.city = '';
            // this.shipping.state = '';
            // this.shipping.postalcode = '';
            this.onChange();
        },
        onZoneChange() {
            let zone = this.shipping_zones[this.shipping_zone_index];
            this.shipping_line.zone_id = zone.id;
            this.shipping_line.zone_title = zone.title;
            this.shipping_line.total = zone.fee;
            this.onChange();
            this.$emit('zone-change', zone);
        },
        async fetchData() {
            let response;
            response = await HttpClient.get('/my/address');
            this.shipping = {
                ...this.shipping,
                ...response.data.shipping
            }

            response = await HttpClient.get('/shipping-zones');
            this.shipping_zones = response.data.items;
            this.shipping_zones.map((s, i) => {
                if (s.title === this.shipping.city) {
                    this.shipping_zone_index = i;
                }
            });

            if (this.shipping_line.method_id === 'flat_rate'){
                let zone = this.shipping_zones[this.shipping_zone_index];
                this.shipping_line.zone_id = zone.id;
                this.shipping_line.zone_title = zone.title;
                this.shipping_line.total = zone.fee;
            }

            this.checkPhoneNumber();
            this.$emit('zone-change');
        },
        onChange() {
            let {shipping, shipping_line} = this;
            this.$emit('change', {shipping, shipping_line});
        }
    },
    mounted() {
        this.fetchData();
    }
}
</script>

<style scoped>

</style>