<template>
    <main-layout>
        <div class="d-flex" slot="header">
            <h2 class="flex-grow-1">订单管理</h2>
        </div>

        <div class="page-section">
            <div class="dsxui-form-inline">
                <div class="form-item">
                    <div class="form-item-label">订单编号</div>
                    <el-input size="medium" class="w200" v-model="params.order_no"/>
                </div>
                <div class="form-item">
                    <div class="form-item-label">买家账号</div>
                    <el-input size="medium" class="w200" v-model="params.buyer_name"/>
                </div>
                <div class="form-item">
                    <div class="form-item-label">商品名称</div>
                    <el-input size="medium" class="w200" v-model="params.title"/>
                </div>
                <div class="form-item">
                    <el-button size="medium" type="primary" @click="onSearch">查询</el-button>
                </div>
            </div>
        </div>
        <div class="page-section" v-loading="loading">
            <div class="table-edit-header">
                <el-tabs @tab-click="onClickTab" value="all">
                    <el-tab-pane label="全部" name="all"/>
                    <el-tab-pane label="待付款" name="pending"/>
                    <el-tab-pane label="处理中" name="processing"/>
                    <el-tab-pane label="配送中" name="deliverying"/>
                    <el-tab-pane label="已完成" name="completed"/>
                    <el-tab-pane label="已取消" name="canceled"/>
                </el-tabs>
            </div>
            <div class="order-list">
                <table class="order-table">
                    <colgroup>
                        <col>
                        <col width="100">
                        <col width="70">
                        <col width="145">
                        <col width="120">
                        <col width="125">
                    </colgroup>
                    <thead>
                    <tr>
                        <th>宝贝</th>
                        <th class="align-center">单价</th>
                        <th class="align-center">数量</th>
                        <th class="align-center">实付款</th>
                        <th class="align-center">交易状态</th>
                        <th class="align-center">交易操作</th>
                    </tr>
                    </thead>
                </table>

                <el-container direction="vertical">
                    <el-checkbox-group v-model="selectionIds">
                        <div v-for="(order,index) in dataList" :key="index">
                            <table class="order-table">
                                <colgroup>
                                    <col>
                                    <col width="100">
                                    <col width="70">
                                    <col width="145">
                                    <col width="120">
                                    <col width="125">
                                </colgroup>
                                <thead>
                                <tr>
                                    <th colspan="2">
                                        <div class="display-flex">
                                            <div class="col-checkbox">
                                                <el-checkbox :label="order.id">{{ '' }}</el-checkbox>
                                            </div>
                                            <div class="col-order-time">{{ order.created_at }}</div>
                                            <div class="col-order-no">订单号:{{ order.order_no }}</div>
                                            <div class="col-order-buyer">
                                                <i class="iconfont icon-peoplefill"></i>
                                                <span>{{ order.buyer_name }}</span>
                                            </div>
                                        </div>
                                    </th>
                                    <th></th>
                                    <th colspan="3" class="align-right">
                                        <i class="el-icon-delete" @click="onDeleteOne(order.id)"></i>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(item,idx) in order.items">
                                    <td>
                                        <div class="order-item">
                                            <img :src="item.image" class="thumb" alt="">
                                            <div class="flex">
                                                <div class="title">{{ item.title }}</div>
                                                <div class="sku">{{ metaValues(item.meta_data) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="align-center">€{{ item.price }}</div>
                                    </td>
                                    <td>
                                        <div class="align-center">x{{ item.quantity }}</div>
                                    </td>
                                    <td>
                                        <div class="align-center" v-if="idx===0">
                                            <p><strong>€{{ order.total }}</strong></p>
                                            <p class="col-freight">(配送费: €{{ order.shipping_total }})</p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="align-center" v-if="idx===0">
                                            <p>{{ order.status_des }}</p>
                                            <p>
                                                <router-link :to="'/order/detail/'+order.id"
                                                             target="_blank">订单详情
                                                </router-link>
                                            </p>
                                            <p>
                                                <a :href="order.links.invoice" target="_blank">电子小票</a>
                                            </p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="align-center" v-if="idx===0">
                                            <el-button size="small" type="primary" @click="onDispose(order)">处理订单
                                            </el-button>
                                            <p v-if="order.status==='pending'">
                                                <a class="ac-link" @click="onCancel(order.id)">取消订单</a>
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </el-checkbox-group>
                </el-container>
            </div>
            <div class="table-edit-footer">
                <el-button size="small" type="primary" :disabled="selectionIds.length===0" @click="onBatchDelete">
                    批量删除
                </el-button>
                <div class="flex"></div>
                <el-pagination
                        background
                        layout="prev, pager, next, total"
                        :total="total"
                        :page-size="pageSize"
                        :current-page="page"
                        @current-change="onPageChange"
                />
            </div>
        </div>
        <dialog-dispose-order
                :order="currentOrder"
                v-model="showOrderDialog"
        />
    </main-layout>
</template>

<script>
import Pagination from "../mixins/Pagination";
import ApiService from "../utils/ApiService";
import DialogDisposeOrder from "./DialogDisposeOrder.vue";

export default {
    name: "OrderList",
    components: {DialogDisposeOrder},
    mixins: [Pagination],
    data() {
        return {
            params: {
                order_no: '',
                buyer_name: '',
                status: 'all'
            },
            showOrderDialog: false,
            currentOrder: {}
        }
    },

    methods: {
        listApi() {
            return '/orders';
        },
        listParams() {
            return this.params;
        },
        onBatchDelete() {
            this.deleteOrders(this.selectionIds);
        },
        onDeleteOne(id) {
            this.deleteOrders([id]);
        },
        deleteOrders(ids) {
            this.$confirm('此操作将永久删除所选订单, 是否继续?', '提示', {
                type: 'warning'
            }).then(() => {
                this.loading = true;
                ApiService.delete('/orders/batch', {data: {ids}}).then(() => {
                    this.fetchList();
                }).catch(reason => {
                    this.$message.error(reason.message);
                }).finally(() => {
                    this.loading = false;
                });
            });
        },
        onClickTab(tab) {
            this.params.status = tab.name;
            this.onSearch();
        },
        metaValues(meta_data) {
            return Object.values(meta_data).join(',');
        },
        onCancel() {

        },
        onDispose(order) {
            this.currentOrder = order;
            this.showOrderDialog = true;
        }
    },
    mounted() {
        this.fetchList();
    },
}
</script>

<style scoped>

</style>
