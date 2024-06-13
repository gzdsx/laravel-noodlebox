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
                        <el-form-item label="配送地址" v-if="order.shipping">
                            <div style="line-height: 1.4; padding-top:8px;">
                                <div>{{ order.shipping.first_name }}</div>
                                <div>{{ order.shipping.address_line_1 }}</div>
                                <div v-if="order.shipping.county">{{ order.shipping.county }}</div>
                                <div v-if="order.shipping.city">{{ order.shipping.city }}</div>
                                <div v-if="order.shipping.state">{{ order.shipping.state }}</div>
                                <div v-if="order.shipping.phone">
                                    <span>+{{ order.shipping.phone.national_number }}</span>
                                    <span>{{ order.shipping.phone.phone_number }}</span>
                                </div>
                            </div>
                        </el-form-item>
                        <el-form-item label="配送方式">
                            <el-select size="medium" class="w300" v-model="order.shipping_method">
                                <el-option
                                        v-for="(v,k) in shippingMethodList"
                                        :label="v"
                                        :value="k"
                                        :key="k"
                                />
                            </el-select>
                        </el-form-item>
                        <el-form-item label="配送区域" v-if="order.shipping_method==='delivery'">
                            <el-select size="medium" class="w300" v-model="order.shipping_zone_id">
                                <el-option
                                        v-for="(v,k) in shippingZones"
                                        :label="v.title+'(€'+v.fee+')'"
                                        :value="v.id"
                                        :key="k"
                                />
                            </el-select>
                        </el-form-item>
                        <el-form-item label="配送员" v-if="order.shipping_method==='delivery'">
                            <el-select size="medium" class="w300" v-model="order.deliveryer_id">
                                <el-option
                                        v-for="(v,k) in deliveryerList"
                                        :label="v.name"
                                        :value="v.id"
                                        :key="k"
                                />
                            </el-select>
                        </el-form-item>
                        <el-form-item label="付款方式">
                            <el-select size="medium" class="w300" v-model="order.payment_method">
                                <el-option
                                        v-for="(v,k) in paymentMethodList"
                                        :label="v"
                                        :value="k"
                                        :key="k"
                                />
                            </el-select>
                        </el-form-item>
                        <el-form-item v-if="order.payment_method==='customize'">
                            <el-input
                                    class="w200"
                                    v-model="order.payment_cash_amount"
                            >
                                <span slot="prepend">By Cash</span>
                            </el-input>
                            <el-input class="w200" :value="payByCardAmount" readonly>
                                <span slot="prepend">By Card</span>
                            </el-input>
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
                                        v-model="varAmount"
                                />
                            </div>
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
                                :timestamp="note.created_at">
                            {{ note.content }}
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
            paymentMethodList: {
                'paypal': 'Pay Online',
                'cash': 'Pay Cash',
                'card': 'Pay by Card Reader',
                'customize': 'Customize'
            },
            shippingMethodList: {
                'delivery': 'Delivery',
                'collection': 'Collection',
            },
            shippingZones: [],
            showOrderItem: false,
            orderItem: {},
            //newOrderTotal: '0.00',
            order_notes: [],
            calculatorType: '+',
            varAmount: '0.00',
            showCalculator: false
        }
    },
    computed: {
        payByCardAmount() {
            return (this.order.total - this.order.payment_cash_amount).toFixed(2);
        },
        newOrderTotal() {
            console.log(Number(this.varAmount));
            return (Number(this.order.total) + Number(this.varAmount)).toFixed(2);
        }
    },
    watch: {
        value(val) {
            if (val) {
                this.fetchOrderNotes();
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
                shipping_method,
                payment_method,
                shipping_zone_id,
                payment_cash_amount,
                status,
                deliveryer_id,
                buyer_note,
                total,
                fee_lines,
                discount_lines
            } = this.order;
            let cost_fee = Number(this.varAmount);
            if (cost_fee > 0) {
                fee_lines.push({
                    name: 'Cost Fee',
                    total: cost_fee
                });
            } else if (cost_fee < 0) {
                discount_lines.push({
                    name: 'Cost Fee',
                    total: Math.abs(cost_fee)
                });
            }
            let discount_total = total - this.newOrderTotal;
            this.loading = true;
            ApiService.put(`/orders/${id}`, {
                shipping_method,
                payment_method,
                shipping_zone_id,
                payment_cash_amount,
                status,
                deliveryer_id,
                buyer_note,
                fee_lines,
                discount_lines,
                total: this.newOrderTotal
            }).then(() => {
                this.varAmount = 0;
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