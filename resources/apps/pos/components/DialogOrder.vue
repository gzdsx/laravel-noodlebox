<template>
    <pos-dialog title="Order Infomation" :visible="value" @close="close">
        <div class="gzdsx-pos-dialog__content" v-if="order.id">
            <div class="order-infos">
                <div class="order-info order-info__number">Order #{{ order.number }}</div>
                <div class="order-info order-info__customer">
                    <div>
                        <span>{{
                            order.payment_method_title
                            }} on {{ $dayjs(order.date_paid).format('DD/MM/YYYY HH:mm') }}</span>
                        <span>-</span>
                        <span class="text-secondary text-capitalize">{{ order.status }}</span>
                    </div>
                    <div v-if="order.shipping">Customer {{ order.shipping.first_name || 'Guest' }}</div>
                </div>
            </div>
            <div class="order-items" v-if="order.line_items">
                <div class="order-item" v-for="(item,index) in order.line_items" :key="index">
                    <div class="order-item__row">
                        <img :src="$imageSrc(item.image.src)" alt="" class="order-item__image">
                        <div class="order-item__name">
                            <div class="order-item__name__title">{{ item.name }}</div>
                            <div class="order-item__name__variations" v-if="item.meta_data.length">
                                <span v-for="(meta,j) in item.meta_data" :key="j">
                                    {{ meta.key|capitalize }},
                                </span>
                            </div>
                        </div>
                        <div class="order-item__price">
                            {{ item.quantity }} x {{ '€' + $toAmount(item.price) }}
                        </div>
                        <div class="order-item__total">€{{ item.total }}</div>
                    </div>
                </div>
            </div>

            <div class="order-totals">
                <div class="order-total" v-for="(f,index) in order.fee_lines" :key="index">
                    <div class="order-total__label">FEE - {{ f.name }}</div>
                    <div class="order-total__price">€{{ f.total }}</div>
                </div>
                <div class="order-total" v-for="(s,index) in order.shipping_lines" :key="index">
                    <div class="order-total__label">SHIPPING - {{ s.method_title }}</div>
                    <div class="order-total__price">€{{ s.total }}</div>
                </div>
                <div class="order-total">
                    <div class="order-total__label">Discount</div>
                    <div class="order-total__price text-citrus">-€{{ order.discount_total }}</div>
                </div>
            </div>

            <div class="order-totals">
                <div class="order-total order-total-total">
                    <div class="order-total__label">Total</div>
                    <div class="order-total__price">€{{ order.total }}</div>
                </div>
                <div class="order-total">
                    <div class="order-total__label">{{ order.payment_method_title }}</div>
                    <div class="order-total__price">€{{ order.total }}</div>
                </div>
            </div>

            <div class="order-notes" v-if="order.customer_note">
                <h5 class="text-uppercase">Note</h5>
                <p>{{ order.customer_note }}</p>
            </div>
        </div>
    </pos-dialog>
</template>

<script>
export default {
    name: "DialogOrder",
    props: {
        value: Boolean,
        order: {
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
            this.$emit('close');
        },
        printOrder() {

        }
    },
    mounted() {

    }
}
</script>

<style scoped>

</style>