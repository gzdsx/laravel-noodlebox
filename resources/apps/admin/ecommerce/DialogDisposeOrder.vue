<template>
    <div>
        <el-dialog
            :title="$t('order.dispose')"
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
                    <el-form label-width="160px" size="medium" v-loading="loading">
                        <el-form-item :label="$t('order.shipping_address')">
                            <div style="line-height: 1.4; padding-top:8px;">
                                <div>{{ shipping.first_name }}</div>
                                <div v-if="shipping.phone_number">
                                    <span>+{{ shipping.national_number }}</span>
                                    <span>{{ shipping.phone_number }}</span>
                                </div>
                                <div>{{ shipping.formatted_address }}</div>
                            </div>
                        </el-form-item>
                        <el-form-item :label="$t('order.shipping_method')">
                            <el-select
                                size="medium"
                                class="w300"
                                v-model="order.shipping_method"
                                @change="onShippingMethodChange"
                            >
                                <el-option
                                    v-for="(v,k) in shippingMethodList"
                                    :label="v"
                                    :value="k"
                                    :key="k"
                                />
                            </el-select>
                        </el-form-item>
                        <el-form-item :label="$t('order.shipping_zone')" v-if="order.shipping_method==='flat_rate'">
                            <el-select
                                size="medium"
                                class="w300"
                                v-model="shipping_line.zone_id"
                                @change="onShippingMethodChange"
                            >
                                <el-option
                                    v-for="(v,k) in shippingZones"
                                    :label="v.title+'(€'+v.fee+')'"
                                    :value="v.id"
                                    :key="k"
                                />
                            </el-select>
                        </el-form-item>
                        <el-form-item :label="$t('order.deliveryer')" v-if="order.shipping_method==='flat_rate'">
                            <el-select size="medium" class="w300" v-model="order.deliveryer_id">
                                <el-option
                                    v-for="(v,k) in deliveryerList"
                                    :label="v.name"
                                    :value="v.id"
                                    :key="k"
                                />
                            </el-select>
                        </el-form-item>
                        <el-form-item :label="$t('order.order_status')">
                            <el-select size="medium" class="w300" v-model="order.status">
                                <el-option
                                    v-for="(v,k) in statusList"
                                    :label="v"
                                    :value="k"
                                    :key="k"
                                />
                            </el-select>
                        </el-form-item>
                        <el-form-item :label="$t('order.order_total')">
                            <el-input
                                class="w300"
                                type="number"
                                :disabled="order.payment_method==='online'"
                                v-model="newTotalValue"
                            >
                                <div slot="prepend">{{ newOrderTotal }}</div>
                                <el-button
                                    type="primary"
                                    :disabled="order.payment_method==='online'"
                                    @click="newOrderTotal=newTotalValue;newTotalValue=0" slot="append">Confirm
                                </el-button>
                            </el-input>
                        </el-form-item>
                        <el-form-item label="Cost Fee">
                            <div class="d-flex">
                                <el-input
                                    class="w300"
                                    type="number"
                                    :disabled="order.payment_method!=='online'"
                                    v-model="newCostTotal"
                                />
                            </div>
                        </el-form-item>
                        <el-form-item :label="$t('order.payment_method')">
                            <el-select
                                size="medium"
                                class="w300"
                                v-model="payment_method"
                                @change="onShippingMethodChange"
                                :disabled="order.payment_method==='online'"
                            >
                                <el-option
                                    v-for="(v,k) in paymentMethodList"
                                    :label="v.title"
                                    :value="v.id"
                                    :key="k"
                                    :disabled="v.id==='online'"
                                />
                            </el-select>
                        </el-form-item>
                        <el-form-item v-if="payment_method==='customize'">
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
                            <el-button type="primary" @click="onSubmit">{{ $t('common.submit') }}</el-button>
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
    </div>
</template>

<script>
import ApiService from "../utils/ApiService";

export default {
    name: "DialogDisposeOrder",
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
                    deliveryer_id: '',
                    shipping_method: ''
                }
            }
        }
    },
    data() {
        return {
            loading: false,
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
            paymentMethodList: [
                {
                    id: 'online',
                    title: 'Pay Online (PayPal & Credit Car)',
                    fee: 0.5,
                },
                {
                    id: 'card',
                    title: 'Pay by Card Reader(Unpaid)',
                    fee: 0.5,
                },
                {
                    id: 'card_reader',
                    title: 'Pay by Card Reader(Paid)',
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
            shipping: {},
            shippingZones: [],
            shipping_line: {
                method_id: 'local_pickup',
                method_title: 'Collection',
                total: '0.00',
                taxes: [],
                zone_id: 0,
                zone_title: ''
            },
            meta_data: {
                payment_with_cash_value: 0
            },
            order_notes: [],
            newOrderTotal: 0,
            newCostTotal: 0,
            newShippingTotal: 0,
            payment_method: 'online',
            newTotalValue: 0
        }
    },
    computed: {
        payByCardValue() {
            return (this.newOrderTotal - this.meta_data.payment_with_cash_value).toFixed(2);
        },
    },
    watch: {
        order(newVal) {
            this.fetchOrderNotes();
            let {shipping, shipping_line, shipping_total, cost_total, total, meta_data} = newVal;
            this.shipping = shipping || {};
            this.shipping_line = {
                ...this.shipping_line,
                ...shipping_line
            }
            this.meta_data = {
                ...this.meta_data,
                ...meta_data,
            }

            this.payment_method = this.order.payment_method || 'online';

            this.newOrderTotal = total;
            this.newCostTotal = cost_total;
            this.newShippingTotal = shipping_total;
        },
    },
    methods: {
        close() {
            this.$emit('input', false);
        },
        fetchStatusList() {
            this.$get('/orders/options').then(response => {
                this.statusList = response.data.status_options;
            });
        },
        fetchDeliveryerList() {
            this.$get('/deliveryers?limit=100&status=online').then(response => {
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
                shipping_method
            } = this.order;
            let {shipping_line, payByCardValue, payment_method} = this;
            let payment_method_title = this.paymentMethodList.filter(item => item.id === payment_method)[0].title;
            let meta_data = {
                ...this.meta_data,
                payment_with_card_value: payByCardValue,
            };

            this.loading = true;
            ApiService.put(`/orders/${id}`, {
                total: this.newOrderTotal,
                cost_total: this.newCostTotal,
                shipping_method,
                shipping_line,
                payment_method,
                payment_method_title,
                deliveryer_id,
                buyer_note,
                meta_data,
                status,
            }).then(() => {
                this.$message.success('Order Updated!');
                this.$emit('update');
            }).finally(() => {
                this.loading = false;
                this.$emit('input', false);
            });
        },
        onShippingMethodChange() {
            let {total, shipping_total, cost_total, shipping_method} = this.order;
            if (shipping_method === 'flat_rate') {
                if (this.shipping_line.zone_id) {
                    for (let zone of this.shippingZones) {
                        if (zone.id === this.shipping_line.zone_id) {
                            this.newShippingTotal = zone.fee;
                        }
                    }
                } else {
                    let zone = this.shippingZones[0];
                    this.newShippingTotal = zone.fee;
                    this.shipping_line.zone_id = zone.id;
                }
            } else {
                this.newShippingTotal = 0;
            }

            console.log(this.newShippingTotal, shipping_total, cost_total);
            let diference = Number(this.newShippingTotal) - Number(shipping_total);
            if (this.order.payment_method === 'online') {
                this.newCostTotal = (Number(cost_total) + Number(diference)).toFixed(2);
            } else {
                this.newOrderTotal = (Number(total) + Number(diference)).toFixed(2);
            }

            console.log(this.newCostTotal);
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