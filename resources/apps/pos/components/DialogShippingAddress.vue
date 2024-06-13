<template>
    <pos-dialog title="Shipping" :visible="value" @close="close">
        <div class="gzdsx-pos-dialog__content">
            <div class="form-group pos-row">
                <div class="pos-col">
                    <div class="form-label">Shipping Method</div>
                    <div>
                        <select class="form-control custom-select" @change="onMethodChange" v-model="shipping_method">
                            <option value="local_pickup">Collection</option>
                            <option value="flat_rate">Delivery</option>
                        </select>
                    </div>
                </div>
                <div class="pos-col">
                    <div class="form-label">Shipping Fee</div>
                    <div>
                        <select class="form-control custom-select" v-model="shipping_index">
                            <option v-for="(m,i) in shipping_lines" :key="i" :value="i">{{ m.method_title }} -
                                €{{ m.total || 0 }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group pos-row">
                <div class="pos-col">
                    <div class="form-label">Name <sub>*</sub></div>
                    <pos-input type="text" :invalid="errors.first_name" v-model="shipping.first_name"/>
                </div>
                <div class="pos-col">
                    <div class="form-label">Phone</div>
                    <pos-input type="text" v-model="shipping.phone"/>
                </div>
            </div>
            <div class="form-group">
                <div class="form-label">Search an Address</div>
                <div>
                    <vue-google-autocomplete
                            ref="address"
                            id="shipping"
                            classname="form-control"
                            autocomplete="off"
                            placeholder="Please type your address"
                            v-on:placechanged="getAddressData"
                            :country="['irl']"
                            :value="addressline"
                            @change="onAddressChange"
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
                    <div class="form-input-label">State</div>
                    <pos-input type="text" v-model="shipping.state"/>
                </div>
                <div class="pos-col">
                    <div class="form-label">Country</div>
                    <pos-input type="text" v-model="shipping.country"/>
                </div>
            </div>
        </div>
        <div class="gzdsx-pos-dialog__footer" slot="footer">
            <button class="btn btn-info form-control text-uppercase" @click="onSubmit">Save Shipping Address</button>
        </div>
    </pos-dialog>
</template>

<script>
import VueGoogleAutocomplete from "../../lib/VueGoogleAutocomplete.vue";

export default {
    name: "DialogShippingAddress",
    components: {VueGoogleAutocomplete},
    props: {
        value: Boolean,
        method: {
            type: String,
            default: 'local_pickup'
        },
        shipping: {
            type: Object,
            default() {
                return {
                    first_name: '',
                    phone: '',
                    city: '',
                    state: '',
                    country: '',
                    postcode: '',
                    address_1: ''
                };
            }
        },
    },
    data() {
        return {
            errors: {
                first_name: null
            },
            zone_methods: [],
            shipping_lines: [],
            shipping_index: 0,
            shipping_method: 'local_pickup',
            addressline: ''
        }
    },
    watch: {
        method(val) {
            this.shipping_method = val;
            this.renderOptions();
        },
        shipping(val) {
            this.resetAddressLine();
        },
    },
    methods: {
        close() {
            this.$emit('input', false);
        },
        onAddressChange(v) {
            this.addressline = v;
        },
        onMethodChange() {
            this.shipping_index = 0;
            this.renderOptions();
        },
        getAddressData(addressData, placeResultData, id) {
            //console.log(addressData);
            //console.log(placeResultData);
            const {formatted_address, address_components} = placeResultData;
            let {
                subpremise,
                street_number,
                route,
                locality,
                country,
                postal_code,
                postal_code_prefix,
                neighborhood,
                administrative_area_level_1,
                administrative_area_level_2,
                postal_town
            } = addressData;


            if (this.shipping_method === 'flat_rate') {
                let check = false;
                this.shipping_lines.map((s, i) => {
                    if (formatted_address.indexOf(s.method_title) !== -1) {
                        check = true;
                        this.shipping_index = i;
                        //this.shipping.city = s.method_title;
                    }
                });

                // if (!check) {
                //     this.$showConfirm({
                //         content: `This address is not within the delivery range`,
                //         confirmText: 'Re Select'
                //     });
                //     this.resetAddressLine();
                //     return false;
                // }

                // const s = this.shipping_lines[this.shipping_index];
                // if (formatted_address.indexOf(s.method_title) === -1) {
                //     this.$showConfirm({
                //         content: `This address is not within the delivery range`,
                //         confirmText: 'Re Select'
                //     });
                //     return false;
                // }
            }

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
        onSubmit() {
            const {shipping} = this;
            const shipping_line = this.shipping_lines[this.shipping_index];
            if (!shipping.first_name) {
                this.errors.first_name = 'This field is required';
                return false;
            } else {
                this.errors.first_name = null;
            }

            if (!shipping.email) {
                shipping.email = this.uniqid() + '@noodlebox.ie';
            }

            if (this.shipping_method === 'flat_rate') {
                let check = false;
                this.shipping_lines.map((s, i) => {
                    let title = s.method_title.toLowerCase();
                    if (this.addressline.toLowerCase().indexOf(title) !== -1) {
                        check = true;
                    }
                });

                if (!check && this.shipping_index === 0) {
                    this.$showConfirm({
                        content: `This address is not within the delivery range`,
                        confirmText: 'Re Select'
                    });
                    return false;
                }
            }

            this.$emit('submit', {shipping, shipping_line});
            this.$emit('input', false);
        },
        fetchZoneMethods() {
            this.$http.get('/shipping-zones').then(res => {
                this.zone_methods = res.data.items;
                this.renderOptions();
            }).catch(err => {
                console.warn(err);
            });
        },
        renderOptions() {
            let shipping_lines = [];
            this.zone_methods.map((m) => {
                if (m.method_id === this.shipping_method) {
                    const total = /\d+/.test(m.settings.cost.value) ? m.settings.cost.value : '0';
                    shipping_lines.push({
                        method_id: m.method_id,
                        method_title: m.title,
                        total
                    });
                }
            });

            this.shipping_lines = shipping_lines;
        },
        resetAddressLine() {
            const {address_1, postcode, city, state, country} = this.shipping;

            let addressline = '', sp = '';
            if (address_1) {
                addressline += sp + address_1;
                sp = ', ';
            }

            if (city) {
                addressline += sp + city;
                if (postcode) {
                    addressline += ' ' + postcode;
                }
                sp = ', ';
            }

            if (state) {
                addressline += sp + state;
                sp = ', ';
            }

            if (country) {
                addressline += sp + country;
            }
            this.addressline = addressline;

            this.shipping_lines.map((s, i) => {
                if (addressline.indexOf(s.method_title) !== -1) {
                    this.shipping_index = i;
                }
            });
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
        }
    },
    mounted() {
        this.fetchZoneMethods();
        this.shipping_method = this.method;
    }
}
</script>

<style scoped>

</style>