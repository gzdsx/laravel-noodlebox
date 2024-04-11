<template>
    <pos-dialog title="Add Discount" :visible="value" @close="close">
        <div class="gzdsx-pos-dialog__content">
            <div class="form-group d-flex column-gap-1">
                <div class="pos-col-6">
                    <div class="form-input-label">Amount type</div>
                    <div>
                        <select class="form-control custom-select" v-model="coupon.discount_type">
                            <option value="fixed_cart">€ Fixed</option>
                            <option value="percent">% Percentage</option>
                        </select>
                    </div>
                </div>
                <div class="pos-col-4">
                    <div class="form-input-label">Amount*</div>
                    <div>
                        <pos-input align="right" v-model="coupon.amount"/>
                    </div>
                </div>
            </div>
            <div class="form-group d-flex column-gap-1">
                <div class="pos-col-6">
                    <div class="form-input-label">Reason (optional)</div>
                    <div>
                        <pos-input v-model="coupon.description"/>
                    </div>
                </div>
                <div class="pos-col-4">
                    <div class="form-input-label">Amount to pay</div>
                    <div>
                        <h3 class="text-right text-primary">€ {{ total }}</h3>
                    </div>
                </div>
            </div>
            <number-pad submit-label="update discount" v-model="coupon.amount" @back="close" @submit="submit"/>
        </div>
    </pos-dialog>
</template>

<script>
import NumberPad from "./NumberPad.vue";
import * as uuid from 'uuid';

export default {
    name: "DialogDiscount",
    components: {NumberPad},
    props: {
        value: Boolean,
        subTotal: {
            type: [String, Number],
            default: 0
        }
    },
    data() {
        return {
            coupon: {
                code: "",
                discount_type: "fixed_cart",
                amount: "0",
                individual_use: true,
                exclude_sale_items: true,
                description: ""
            }
        }
    },
    computed: {
        total() {
            const amount = this.coupon.amount || 0;
            if (this.coupon.discount_type === 'fixed_cart') {
                return (parseFloat(this.subTotal) - parseFloat(amount)).toFixed(2);
            }

            if (this.coupon.discount_type === 'percent') {
                if (parseFloat(amount) > 0) {
                    return (parseFloat(this.subTotal) * parseFloat(amount) / 100).toFixed(2);
                } else {
                    return parseFloat(this.subTotal).toFixed(2);
                }
            }

            return 0;
        }
    },
    methods: {
        close() {
            this.$emit('input', false);
        },
        submit() {
            const {coupon} = this;
            coupon.code = uuid.v4();

            this.$http.post('coupons', coupon).then(resp => {
                this.$emit('submit', resp);
                this.$emit('input', false);
            }).catch(reason => {
                console.log(reason);
            }).finally(() => {

            });
        }
    },
    mounted() {

    }
}
</script>

<style scoped>

</style>