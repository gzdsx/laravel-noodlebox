<template>
    <div>
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
</template>

<script>
export default {
    name: "CheckoutAddress",
    data() {
        return {
            shipping: {
                first_name: '',
                last_name: '',
                address_line_1: '',
                address_line_2: '',
                city: '',
                postal_code: '',
                country: 'Ireland',
                state: '',
                phone: '',
            },
            phone: {
                national_number: '353',
                phone_number: '',
            },
            phoneVerified: false,
            showCodeInput: false,
            verificationCode: '',
            sendingCodeText: 'Send code',
            disabledSendCode: false,
            shipping_zones: [],
            shipping_zone_index: 0,
            shipping_method: 'delivery',
            buyer_note: '',
            errors: {},
            formatted_address: '',
        }
    }
}
</script>

<style scoped>

</style>