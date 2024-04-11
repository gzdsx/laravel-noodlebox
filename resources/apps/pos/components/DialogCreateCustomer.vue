<template>
    <pos-dialog :title="dialogTitle" :visible="value" @close="close">
        <div class="gzdsx-pos-dialog__content">
            <div class="form-group pos-row">
                <div class="pos-col">
                    <div class="form-label">Name<sup>*</sup></div>
                    <pos-input type="text" :invalid="errors.first_name" v-model="shipping.first_name"/>
                </div>
                <div class="pos-col">
                    <div class="form-label">Phone</div>
                    <pos-input type="text" v-model="shipping.phone"/>
                </div>
            </div>
            <h3>Shipping Address</h3>
            <div class="form-group">
                <div class="pos-input">
                    <vue-google-autocomplete
                            id="billing"
                            ref="billing"
                            classname="pos-input__input"
                            placeholder="Please enter 2 or more characters"
                            v-on:placechanged="getShippingAddress"
                            :country="['irl']"
                            @change="addressChange"
                    />
                </div>
            </div>
            <div class="form-group pos-row">
                <div class="pos-col">
                    <div class="form-label">City</div>
                    <pos-input type="text" v-model="shipping.city"/>
                </div>
                <div class="pos-col">
                    <div class="form-label">Post Code</div>
                    <pos-input type="text" v-model="shipping.postcode"/>
                </div>
            </div>
            <div class="form-group pos-row">
                <div class="pos-col">
                    <div class="form-label">State</div>
                    <pos-input type="text" v-model="shipping.state"/>
                </div>
                <div class="pos-col">
                    <div class="form-label">Country</div>
                    <pos-input type="text" v-model="shipping.country"/>
                </div>
            </div>
            <div class="form-group pos-invalid-feedback" v-if="responseError">{{ responseError }}</div>
        </div>
        <div class="gzdsx-pos-dialog__footer" slot="footer">
            <button class="btn btn-primary form-control text-uppercase" @click="onSubmit">save customer information
            </button>
        </div>
        <pos-loading :visible="showLoading"/>
    </pos-dialog>
</template>

<script>
import VueGoogleAutocomplete from "./VueGoogleAutocomplete";

export default {
    name: "DialogCreateCustomer",
    components: {VueGoogleAutocomplete},
    props: {
        value: Boolean,
        customer: {
            type: Object,
            default() {
                return {
                    first_name: "",
                    last_name: "",
                    email: "",
                    password: "",
                    billing: {},
                    shipping: {},
                    meta_data: []
                }
            }
        },
        shippingMethod:{
            type:String,
            default: 'Standard'
        }
    },
    data() {
        return {
            billing: {},
            shipping: {
                country: 'Ireland',
                city: 'Drogheda',
                state: 'LH'
            },
            billing_vat: '',
            errors: {
                first_name: false,
                email: false
            },
            responseError: null,
            showLoading: false,
            shippingAbles: [],
            dialogTitle:''
        }
    },
    watch: {
        customer(val) {
            this.bindData();
        },
        shippingMethod(val) {
            this.bindData();
            this.setDialogTitle();
        }
    },
    methods: {
        close() {
            this.$emit('input', false);
        },
        getShippingAddress(addressData, placeResultData, id) {
            //console.log(addressData);
            //console.log(placeResultData);
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
            //
            // let check = false;
            // this.shippingAbles.map((s, i) => {
            //     if (formatted_address.indexOf(s.title) !== -1) {
            //         check = true;
            //         this.shipping.city = s.title;
            //         this.$forceUpdate();
            //     }
            // });
            //
            // if (!check) {
            //     this.$showConfirm({
            //         content: `This address is not within the delivery range`,
            //         confirmText: 'Re Select'
            //     });
            //     return false;
            // }

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
                this.shipping.postcode = postal_code;
            } else {
                this.shipping.postcode = postal_code_prefix;
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

            this.shipping.address_1 = address;
            this.$forceUpdate();
        },
        addressChange(v) {
            //this.shipping.address_1 = v;
        },
        bindData() {
            const {billing, shipping, meta_data} = this.customer;
            if (this.shippingMethod !== 'local_pickup'){
                if (!billing.first_name) {
                    billing.first_name = 'customer_' + billing.phone;
                }

                if (!shipping.first_name) {
                    shipping.first_name = 'customer_' + shipping.phone;
                }
                this.$forceUpdate();
            }

            if (billing) this.billing = billing;
            if (shipping) this.shipping = shipping;
            if (meta_data) {
                for (let meta of meta_data) {
                    if (meta.key === 'billing_vat') {
                        this.billing_vat = meta.value;
                    }
                }
            }
        },
        onSubmit() {
            let {shipping, billing_vat} = this;
            let {first_name, last_name} = this.shipping;
            let email = this.uniqid() + '@noodlebox.ie';

            if (!shipping.email) shipping.email = email;
            let customer = {
                first_name,
                last_name,
                email,
                password: '123456',
                billing: shipping,
                shipping
            }

            if (billing_vat) {
                customer.meta_data = [
                    {
                        key: 'billing_vat',
                        value: billing_vat
                    }
                ]
            }

            let check = true;
            if (!first_name) {
                this.errors.first_name = 'This field is required';
                check = false;
            } else {
                this.errors.first_name = false;
            }

            if (!check) return false;

            this.showLoading = true;
            const c = this.customer;
            if (c.id) {
                this.$http.put('customers/' + c.id, customer).then(response => {
                    this.$emit('update', response);
                    this.close();
                }).catch(reason => {
                    this.responseError = reason.message;
                }).finally(() => {
                    this.showLoading = false;
                });
            } else {
                this.$http.post('customers?_locale=user', customer).then(response => {
                    this.$emit('update', response);
                    this.close();
                }).catch(reason => {
                    this.responseError = reason.message;
                }).finally(() => {
                    this.showLoading = false;
                });
            }
        },
        change(v) {
            if (this.$refs.switch.checked) {
                this.shipping = this.billing;
            }
        },
        uniqid() {
            var s = [];
            var hexDigits = "0123456789abcdef";
            for (var i = 0; i < 36; i++) {
                s[i] = hexDigits.substr(Math.floor(Math.random() * 0x10), 1);
            }
            s[14] = "4";  // bits 12-15 of the time_hi_and_version field to 0010
            s[19] = hexDigits.substr((s[19] & 0x3) | 0x8, 1);  // bits 6-7 of the clock_seq_hi_and_reserved to 01
            s[8] = s[13] = s[18] = s[23] = "";

            return 'ai-' + s.join("").substr(0, 10);
        },
        setDialogTitle(){
            if (this.shippingMethod === 'local_pickup'){
                this.dialogTitle = 'Create new customer profile - Collection';
            }else {
                this.dialogTitle = 'Create new customer profile - Delivery';
            }
        }
    },
    mounted() {
        this.bindData();
        this.setDialogTitle();
    }
}
</script>

<style scoped>

</style>