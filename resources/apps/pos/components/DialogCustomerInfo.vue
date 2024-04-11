<template>
    <pos-dialog title="Customer" :visible="value" @close="close">
        <div class="gzdsx-pos-dialog__content pos-customer-container">
            <div class="customer-current">
                <img :src="customer.avatar_url" class="avatar" alt="">
                <div class="name">{{ customer.first_name }} {{ customer.last_name }}({{ customer.email }})</div>
            </div>

            <div class="customer-info-box" @click="edit">
                <div class="customer-info-box__row"><strong>Name:</strong>
                    {{ customer.first_name }}
                    {{ customer.last_name }}
                </div>
                <div class="customer-info-box__row" v-if="customer.shipping">
                    <strong>Phone:</strong>
                    {{ customer.shipping.phone }}
                </div>
                <div class="customer-info-box__row" v-if="customer.shipping">
                    <strong>Shipping address:</strong>
                    <span>
                            {{ customer.shipping.address_1 }}
                            {{ customer.shipping.city }}
                            {{ customer.shipping.country }}
                    </span>
                </div>
                <i class="customer-info-box__edit yith-pos-icon-pencil"></i>
                <div class="customer-info-box__error">
                    The following fields are required for billing details: first name, last name, email.
                </div>
                <div class="customer-info-box__error">
                    The following fields are required for shipping details: first name, last name.
                </div>
            </div>
        </div>
        <div class="gzdsx-pos-dialog__footer" slot="footer">
            <button class="btn btn-primary btn-block text-uppercase" @click="submit">Use this customer profile
            </button>
        </div>
    </pos-dialog>
</template>

<script>
export default {
    name: "DialogCustomerInfo",
    props: {
        value: Boolean,
        customer: {
            type: Object,
            default() {
                return {};
            }
        }
    },
    data() {
        return {

        }
    },
    methods: {
        close() {
            this.$emit('input', false);
        },
        edit() {
            this.$emit('edit', this.customer);
        },
        submit() {
            this.$emit('submit', this.customer);
            this.close();
        }
    },
    mounted() {
        this.visible = this.value;
    }
}
</script>

<style scoped>

</style>