<template>
    <pos-dialog title="Check Out" ref="dialog" :visible="value" @close="close">
        <div class="gzdsx-pos-dialog__content">
            <div class="order-items">
                <div class="order-item" v-for="(item,index) in order.line_items" :key="item.id">
                    <div class="order-item__row">
                        <img :src="$imageSrc(item.image.src)" alt="" class="order-item__image">
                        <div class="order-item__name">
                            <div class="order-item__name__title">{{ item.name }}</div>
                            <div class="order-item__name__variations" v-if="item.variation_name">{{
                                item.variation_name
                                }}
                            </div>
                            <div class="order-item__name__comments" v-if="item.comments">
                                <div class="order-item__name__comment" v-for="(comment,j) in item.comments" :key="j">
                                    <div class="title">{{ comment.type|capitalize }}-{{ comment.name }}</div>
                                    <div class="price">€{{ $toAmount(comment.price) }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="order-item__price">
                            {{ '€' + $toAmount(item.price) }} x {{ item.quantity }}
                        </div>
                        <div class="order-item__total">€{{ item.total }}</div>
                    </div>
                </div>
            </div>
            <div class="order-totals">
                <div class="order-total">
                    <div class="order-total__label">Subtotal</div>
                    <div class="order-total__price">€{{ $toAmount(order.subTotal) }}</div>
                </div>
                <div class="order-total" v-for="(s,idx) in order.shipping_lines" :key="'b'+idx">
                    <div class="order-total__label">Shipping - {{ s.method_title }}</div>
                    <div class="order-total__price">€{{ s.total }}</div>
                </div>
                <div class="order-total" v-for="(f,idx) in order.fee_lines" :key="'a'+idx">
                    <div class="order-total__label">Fee - {{ f.name }}</div>
                    <div class="order-total__price">€{{ f.total }}</div>
                </div>
                <div class="order-total order-total-total ">
                    <div class="order-total__label">Total</div>
                    <div class="order-total__price">€{{ $toAmount(order.total) }}</div>
                </div>
                <div class="order-total">
                    <div class="order-total__label">Payment method</div>
                    <div class="order-total__price pos-col-3">
                        <select class="form-control custom-select" @change="onPayChange" v-model="methodIndex">
                            <option v-for="(o,index) in paymentOptions" :value="index" :key="index">{{
                                o.title
                                }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="gzdsx-pos-dialog__footer" slot="footer">
            <div class="flex-grow-1 d-flex column-gap-1">
                <div class="btn btn-light" @click="prevPage">Prev</div>
                <div class="btn btn-light" @click="nextPage">Next</div>
            </div>
            <div>
                <button class="btn btn-info btn-lg btn-block text-uppercase" @click="onSubmit">check out</button>
            </div>
        </div>
        <pos-loading :visible="showLoading"/>
    </pos-dialog>
</template>

<script>
import NumberPad from "./NumberPad.vue";

export default {
    name: "DialogPayment",
    components: {NumberPad},
    props: {
        value: Boolean,
        order: {
            type: Object,
            default() {
                return {
                    line_items: []
                }
            }
        }
    },
    watch: {
        value(val) {
            if (val) {
                this.$nextTick(() => {
                    this.$refs.dialog.$refs.body.scrollTop = this.$refs.dialog.$refs.body.scrollHeight;
                });
            }
        },
    },
    data() {
        return {
            amount: '0',
            paymentOptions: [
                {
                    method_id: "jetpack_custom_gateway_2",
                    method_title: 'Pay Via Cash',
                    title: 'Pay Via Cash',
                    fee: 0
                },
                {
                    method_id: "jetpack_custom_gateway",
                    method_title: 'Pay Via Card',
                    title: 'Pay by Card Reader',
                    fee: 0.5
                },
                {
                    method_id: "jetpack_custom_gateway_3",
                    method_title: 'Pay in Store',
                    title: 'Pay in Store',
                    fee: 0
                }
            ],
            showLoading: false,
            methodIndex: 0,
            payMethod: {},
            submitting: false,
        }
    },
    methods: {
        close() {
            this.$emit('input', false);
        },
        onAmountChange(v) {
            this.amount = v;
        },
        onSubmit() {
            let {order, methodIndex} = this;
            let payment = this.paymentOptions[methodIndex];
            order.line_items = order.line_items.map((item => {
                const {product_id, name, image, quantity, variation_id, price, total, subtotal, meta_data} = item;
                return {
                    product_id,
                    name,
                    image,
                    quantity,
                    variation_id,
                    meta_data,
                    price,
                    total: total.toString(),
                    subtotal: subtotal.toString(),
                }
            }));

            if (this.submitting){
                return false;
            }else {
                this.submitting = true;
            }

            this.showLoading = true;
            this.$http.post('orders', {
                ...order,
                payment_method: payment.method_id,
                payment_method_title: payment.method_title,
            }).then(response => {
                this.$emit('success', response);
            }).catch(reason => {
                this.$emit('error', reason);
                this.$showConfirm({
                    content: reason.message
                });
            }).finally(() => {
                this.showLoading = false;
                this.submitting = false;
                this.close();
            });
        },
        fetchPaymentOptions() {
            this.$http.get('payment_gateways').then(response => {
                //this.paymentOptions = response;
            });
        },
        onPayChange() {
            const name = 'Card Fee';
            this.payMethod = this.paymentOptions[this.methodIndex];
            if (this.payMethod.method_id === 'jetpack_custom_gateway') {
                this.order.fee_lines.push({
                    name,
                    total: this.payMethod.fee.toString()
                });
            } else {
                this.order.fee_lines = this.order.fee_lines.filter(item => item.name !== name);
            }
        },
        prevPage() {
            this.$refs.dialog.$refs.body.scrollTop -= 100;
        },
        nextPage() {
            this.$refs.dialog.$refs.body.scrollTop += 100;
        }
    },
    mounted() {
        this.fetchPaymentOptions();
        this.payMethod = this.paymentOptions[this.methodIndex];
    }
}
</script>

<style scoped>

</style>