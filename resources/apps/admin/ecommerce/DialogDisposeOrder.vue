<template>
    <div>
        <el-dialog
                title="订单处理"
                width="75%"
                :visible="value"
                :close-on-click-modal="false"
                :close-on-press-escape="false"
                append-to-body
                closeable
                @close="close"
        >
            <el-row :gutter="20" type="flex">
                <el-col :span="12">
                    <el-form label-width="100px" size="medium" v-loading="loading">
                        <el-form-item label="配送地址">
                            <div style="line-height: 1.4; padding-top:8px;">
                                <div>{{ shipping.first_name }}</div>
                                <div>{{ shipping.address_line_1 }}</div>
                                <div v-if="shipping.county">{{ shipping.county }}</div>
                                <div v-if="shipping.city">{{ shipping.city }}</div>
                                <div v-if="shipping.state">{{ shipping.state }}</div>
                                <div v-if="shipping.phone">
                                    <span>+{{ shipping.phone.national_number }}</span>
                                    <span>{{ shipping.phone.phone_number }}</span>
                                </div>
                            </div>
                        </el-form-item>
                        <el-form-item label="配送方式">
                            <el-select size="medium" class="w300" v-model="shipping_line.method_id">
                                <el-option
                                        v-for="(v,k) in shippingMethodList"
                                        :label="v"
                                        :value="k"
                                        :key="k"
                                />
                            </el-select>
                        </el-form-item>
                        <el-form-item label="配送区域" v-if="shipping_line.method_id==='flat_rate'">
                            <el-select size="medium" class="w300" v-model="shipping_line.zone_id">
                                <el-option
                                        v-for="(v,k) in shippingZones"
                                        :label="v.title+'(€'+v.fee+')'"
                                        :value="v.id"
                                        :key="k"
                                />
                            </el-select>
                        </el-form-item>
                        <el-form-item label="配送员" v-if="shipping_line.method_id==='flat_rate'">
                            <el-select size="medium" class="w300" v-model="order.deliveryer_id">
                                <el-option
                                        v-for="(v,k) in deliveryerList"
                                        :label="v.name"
                                        :value="v.id"
                                        :key="k"
                                />
                            </el-select>
                        </el-form-item>
                        <el-form-item label="订单状态">
                            <el-select size="medium" class="w300" v-model="order.status">
                                <el-option
                                        v-for="(v,k) in statusList"
                                        :label="v"
                                        :value="k"
                                        :key="k"
                                />
                            </el-select>
                        </el-form-item>
                        <el-form-item label="订单总价">
                            <el-input
                                    class="w300"
                                    type="number"
                                    :value="newOrderTotal"
                            />
                        </el-form-item>
                        <el-form-item label="Cost Fee">
                            <div class="d-flex">
                                <el-input
                                        class="w300"
                                        type="number"
                                        v-model="meta_data.cost_total"
                                />
                            </div>
                        </el-form-item>
                        <el-form-item label="付款方式">
                            <el-select size="medium" class="w300" v-model="order.payment_method">
                                <el-option
                                        v-for="(v,k) in paymentMethodList"
                                        :label="v.title"
                                        :value="v.id"
                                        :key="k"
                                />
                            </el-select>
                        </el-form-item>
                        <el-form-item v-if="order.payment_method==='customize'">
                            <el-input
                                    class="w200"
                                    v-model="meta_data.payment_with_cash_value"
                            >
                                <span slot="prepend">By Cash</span>
                            </el-input>
                            <el-input class="w200" :value="payByCardValue" readonly>
                                <span slot="prepend">By Card</span>
                            </el-input>
                        </el-form-item>
                        <el-form-item>
                            <el-button type="primary" @click="onSubmit">提交</el-button>
                        </el-form-item>
                    </el-form>
                </el-col>
                <el-col :span="12">
                    <div>Customer Notes</div>
                    <el-input
                            type="textarea"
                            class="w500"
                            :rows="3"
                            v-model="order.buyer_note"
                    />

                    <div style="margin:10px 0;">Order Logs</div>
                    <el-timeline>
                        <el-timeline-item
                                v-for="(note, index) in order_notes"
                                :key="index"
                                :timestamp="note.created_at"
                        >
                            <div class="el-timeline-item__content" v-html="note.content"></div>
                        </el-timeline-item>
                    </el-timeline>
                </el-col>
            </el-row>
        </el-dialog>
        <dialog-edit-order-item
                :order-item="orderItem"
                v-model="showOrderItem"
                @update="showOrderItem=false"
        />
    </div>
</template>

<script>
import ApiService from "../utils/ApiService";
import DialogEditOrderItem from "./DialogEditOrderItem.vue";

export default {
    name: "DialogDisposeOrder",
    components: {DialogEditOrderItem},
    props: {
        value: {
            type: Boolean,
            default: false
        },
        order: {
            type: Object,
            default() {
                return {
                    status: 'pending',
                    deliveryer_id: ''
                }
            }
        }
    },
    data() {
        return {
            statusList: [],
            deliveryerList: [
                {
                    id: 0,
                    name: 'Please Select'
                }
            ],
            disposeData: {
                status: 'pending',
                deliveryer_id: ''
            },
            loading: false,
            paymentMethodList: [
                {
                    id: 'online',
                    title: 'Pay Online (PayPal & Credit Car)',
                    fee: 0.5,
                },
                {
                    id: 'card',
                    title: 'Pay by Card Reader',
                    fee: 0.5,
                },
                {
                    id: 'cash',
                    title: 'Pay Cash',
                    fee: 0.0,
                },
                {
                    id: 'customize',
                    title: 'Customize',
                    fee: 0.0,
                }
            ],
            shippingMethodList: {
                'flat_rate': 'Delivery',
                'local_pickup': 'Collection',
            },
            shippingZones: [],
            showOrderItem: false,
            orderItem: {},
            //newOrderTotal: '0.00',
            order_notes: [],
            calculatorType: '+',
            showCalculator: false,
            shipping: {},
            shipping_line: {
                method_id: 'local_pickup',
                method_title: 'Collection',
                total: '0.00',
                taxes: [],
                zone_id: 0,
                zone_title: ''
            },
            meta_data: {
                cost_total: 0,
                payment_with_cash_value: 0
            }
        }
    },
    computed: {
        payByCardValue() {
            return (this.newOrderTotal - this.meta_data.payment_with_cash_value).toFixed(2);
        },
        newOrderTotal() {
            let total = Number(this.order.total) + Number(this.meta_data.cost_total) - Number(this.order.shipping_total);
            this.shippingZones.filter(item => item.id === this.shipping_line.zone_id).map(item => {
                total += Number(item.fee);
            });
            return total.toFixed(2);
        },
    },
    watch: {
        value(val) {
            if (val) {
                this.fetchOrderNotes();
                let {shipping, shipping_line, metas} = this.order;
                this.shipping = shipping || {};
                this.shipping_line = {
                    ...this.shipping_line,
                    ...shipping_line
                }

                metas.map(item => {
                    this.meta_data[item.meta_key] = item.meta_value;
                });
            }
        }
    },
    methods: {
        close() {
            this.$emit('input', false);
        },
        fetchStatusList() {
            this.$get('/orders/statuses').then(response => {
                this.statusList = response.data;
            });
        },
        fetchDeliveryerList() {
            this.$get('/deliveryers?limit=100').then(response => {
                this.deliveryerList = this.deliveryerList.concat(response.data.items);
            });
        },
        fetchShippingZones() {
            this.$get('/shipping-zones').then(response => {
                this.shippingZones = response.data.items;
            });
        },
        fetchOrderNotes() {
            this.$get(`/orders/${this.order.id}/notes`).then(response => {
                this.order_notes = response.data.items;
            });
        },
        onSubmit() {
            let {
                id,
                status,
                buyer_note,
                deliveryer_id,
                fee_lines,
                discount_lines,
                payment_method,
            } = this.order;
            let {shipping_line, newOrderTotal} = this;
            if (shipping_line.method_id === 'flat_rate') {
                shipping_line.method_title = 'Delivery';
                let zone = this.shippingZones.filter(item => item.id === shipping_line.zone_id)[0];
                if (zone) {
                    shipping_line.total = zone.fee;
                    shipping_line.zone_title = zone.title;
                    shipping_line.zone_id = zone.id;
                }
            } else {
                shipping_line.method_title = 'Collection';
                shipping_line.total = 0;
                shipping_line.zone_title = '';
                shipping_line.zone_id = 0;
            }

            let payment_method_title = this.paymentMethodList.filter(item => item.id === payment_method)[0].title;
            let metas = [];
            this.meta_data.payment_with_card_value = this.payByCardValue;
            for (let k in this.meta_data) {
                metas.push({
                    meta_key: k,
                    meta_value: this.meta_data[k]
                });
            }

            this.loading = true;
            ApiService.put(`/orders/${id}`, {
                shipping_line,
                payment_method,
                payment_method_title,
                status,
                deliveryer_id,
                buyer_note,
                fee_lines,
                discount_lines,
                total: newOrderTotal,
                metas
            }).then(() => {
                this.$message.success('订单已更新');
                this.$emit('update');
            }).finally(() => {
                this.loading = false;
                this.$emit('input', false);
            });
        },
        subTotal(item) {
            return item.price * item.quantity;
        },
        handlerShowItem(item) {
            this.orderItem = item;
            this.showOrderItem = true;
        },
        onCalculate() {
            if (this.calculatorType === '+') {
                this.newOrderTotal = (Number(this.order.total) + Number(this.varAmount)).toFixed(2);
            } else {
                this.newOrderTotal = Number(this.order.total) - Number(this.varAmount).toFixed(2);
            }
            this.showCalculator = false;
        }
    },
    mounted() {
        this.fetchStatusList();
        this.fetchDeliveryerList();
        this.fetchShippingZones();
    },
}
</script>

<style scoped>

</style>