<template>
    <main-layout>
        <div class="d-flex" slot="header">
            <h2>订单详情</h2>
        </div>

        <section class="page-section" v-loading="loading">
            <div class="edit-title">
                <strong>商品信息</strong>
            </div>
            <table class="order-table">
                <thead>
                <tr>
                    <th>宝贝</th>
                    <th></th>
                    <th class="align-center">单价</th>
                    <th class="align-center">数量</th>
                    <th class="align-center">优惠</th>
                    <th class="align-center">实付款</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(item,idx) in order.items">
                    <td>
                        <div class="order-item">
                            <img :src="item.image" class="thumb" alt="">
                            <div class="flex">
                                <div class="title">{{ item.title }}</div>
                                <div class="item-metas" v-if="item.meta_data.options">
                                    {{ metaValues(item.meta_data.options) }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td></td>
                    <td>
                        <div class="align-center">€{{ item.price }}</div>
                    </td>
                    <td>
                        <div class="align-center">x{{ item.quantity }}</div>
                    </td>
                    <td>
                        <div class="align-center" v-if="idx===0">
                            <p>-￥{{ order.discount_total }}</p>
                        </div>
                    </td>
                    <td>
                        <div class="align-center" v-if="idx===0">
                            <p><strong>￥{{ order.total }}</strong></p>
                            <p class="col-freight">(配送费: €{{ order.shipping_total }})</p>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
            <table class="dsxui-formtable">
                <colgroup>
                    <col width="80">
                    <col>
                </colgroup>
                <tbody>
                <tr>
                    <td class="cell-label">订单编号</td>
                    <td>{{ order.order_no }}</td>
                </tr>
                <tr>
                    <td class="cell-label">创建时间</td>
                    <td>{{ order.created_at }}</td>
                </tr>
                <tr>
                    <td class="cell-label">订单状态</td>
                    <td>{{ order.status_des }}</td>
                </tr>
                <tr>
                    <td class="cell-label">订单金额</td>
                    <td>{{ order.total }}</td>
                </tr>
                <tr>
                    <td class="cell-label">付款方式</td>
                    <td>{{ order.payment_method_title }}</td>
                </tr>
                <tr>
                    <td class="cell-label" valign="top">配送地址</td>
                    <td>
                        <div v-if="shipping.first_name">{{ shipping.first_name }}</div>
                        <div v-if="shipping.last_name">{{ shipping.last_name }}</div>
                        <div v-if="shipping.address_line_1">{{ shipping.address_line_1 }}</div>
                        <div v-if="shipping.address_line_2">{{ shipping.address_line_2 }}</div>
                        <div v-if="shipping.city">{{ shipping.city }}</div>
                        <div v-if="shipping.state">{{ shipping.state }}</div>
                        <div v-if="shipping.postal_code">{{ shipping.postal_code }}</div>
                        <div v-if="shipping.country">{{ shipping.country }}</div>
                        <div v-if="shipping.phone">
                            <span v-if="shipping.phone.national_number">+{{ shipping.phone.national_number }}</span>
                            <span v-if="shipping.phone.phone_number">{{ shipping.phone.phone_number }}</span>
                        </div>
                        <div v-if="shipping.email">{{ shipping.email }}</div>
                    </td>
                </tr>
                <tr v-if="order.deliveryer">
                    <td class="cell-label">配送员</td>
                    <td>{{ order.deliveryer.name }}</td>
                </tr>
                <tr>
                    <td class="cell-label"></td>
                    <td>
                        <el-button size="medium" type="primary" @update="onOrderUpdated" @click="showDialog=true">
                            订单处理
                        </el-button>
                    </td>
                </tr>
                </tbody>
            </table>
        </section>
        <dialog-dispose-order v-model="showDialog" :order="order"/>
    </main-layout>
</template>

<script>
import ApiService from "../utils/ApiService";
import DialogDisposeOrder from "./DialogDisposeOrder.vue";

export default {
    name: "OrderDetail",
    components: {DialogDisposeOrder},
    data() {
        return {
            order: {},
            shipping: {},
            statusList: [],
            deliveryerList: [],
            order_data: {
                status: 'pending',
                deleiveryer_id: ''
            },
            loading: true,
            showDialog: false
        }
    },
    methods: {
        fetchData() {
            let {id} = this.$route.params;
            if (!id) return;
            ApiService.get(`/orders/${id}`).then(response => {
                this.order = response.data;
                const {shipping, status, deliveryer_id} = response.data;
                this.shipping = shipping;
                this.order_data = {status, deliveryer_id};
            }).finally(() => {
                this.loading = false;
            });
        },
        onSubmit() {
            const {id} = this.order;
            const {status, deliveryer_id} = this.order_data;

            this.loading = true;
            ApiService.put(`/orders/${id}`, {
                order: {
                    status,
                    deliveryer_id
                }
            }).then(() => {
                this.fetchData();
                this.$message.success('订单已更新');
            }).finally(() => {
                this.loading = false;
            });
        },
        metaValues(meta) {
            return Object.values(meta).join(',');
        },
        formatAddress(address) {
            let str = '';
            if (address.address) {
                str += address.address + ' ';
            }

            if (address.county) {
                str += address.county + ' ';
            }

            if (address.city) {
                str += address.city + ' ';
            }

            if (address.state) {
                str += address.state + ' ';
            }

            if (address.country) {
                str += address.country + ' ';
            }
            return str + ',' + address.name + ',' + address.phone;
        },
        fetchStatusList() {
            this.$get('/orders/statuses').then(response => {
                this.statusList = response.data;
            });
        },
        fetchDeliveryerList() {
            this.$get('/deliveryers?limit=100').then(response => {
                this.deliveryerList = response.data.items;
            });
        },
        onOrderUpdated() {
            this.fetchData();
            this.showDialog = false;
        }
    },
    mounted() {
        this.fetchData();
        this.fetchStatusList();
        this.fetchDeliveryerList();
    },
}
</script>

<style scoped>

</style>
