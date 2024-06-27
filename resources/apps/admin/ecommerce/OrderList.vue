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
        <div class="page-section">
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
            <el-table :data="dataList" v-loading="loading" @selection-change="onSelectionChange">
                <el-table-column width="45" type="selection"/>
                <el-table-column width="auto" label="Order">
                    <template slot-scope="scope">
                        <div class="post-column-title">
                            <router-link :to="'/order/detail/' + scope.row.id" target="_blank">
                                <span class="text-danger font-weight-bold"
                                      v-if="scope.row.is_modified">{{ scope.row.order_no }}</span>
                                <span class="text-primary" v-else>{{ scope.row.order_no }}</span>
                            </router-link>
                        </div>
                        <div class="post-column-actions">
                            <span>{{ scope.row.buyer_name }}</span>
                            <span>|</span>
                            <span><a :href="scope.row.links.invoice" target="_blank">Invoice</a></span>
                        </div>
                    </template>
                </el-table-column>
                <el-table-column label="Ship to" width="200">
                    <template slot-scope="scope">
                        <div style="line-height: 1.1"><small>{{ formatAddress(scope.row.shipping) }}</small></div>
                    </template>
                </el-table-column>
                <el-table-column label="Status" width="100" prop="status"/>
                <el-table-column label="Date" width="170" prop="created_at"/>
                <el-table-column label="Driver" width="100" prop="driver">
                    <template slot-scope="scope">
                        <div v-if="scope.row.deliveryer">
                            <span :style="{'color': scope.row.deliveryer.color}">{{ scope.row.deliveryer.name }}</span>
                        </div>
                        <div v-else>----</div>
                        <div><strong>{{ scope.row.short_code }}</strong></div>
                    </template>
                </el-table-column>
                <el-table-column label="Shipping M" width="100" prop="shipping_method">
                    <template slot-scope="scope">
                        <div v-if="scope.row.shipping_line">
                            <div>{{ scope.row.shipping_line.method_title }}</div>
                            <small>{{ scope.row.shipping_line.zone_title}}</small>
                        </div>
                    </template>
                </el-table-column>
                <el-table-column label="Total" width="80">
                    <template slot-scope="scope">
                        {{ '€' + scope.row.total }}
                    </template>
                </el-table-column>
                <el-table-column label="Created Via" width="100" prop="created_via"/>
                <el-table-column label="Actions" width="100" align="right" fixed="right">
                    <template slot-scope="scope">
                        <div>
                            <el-button size="mini" type="text" @click="onDispose(scope.row)">处理订单</el-button>
                        </div>
                        <div>
                            <el-button size="mini" type="text" @click="onPrint(scope.row)">Print</el-button>
                        </div>
                    </template>
                </el-table-column>
            </el-table>
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
                @update="fetchList"
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
            currentOrder: {},
            invoceLink: '',
            interval: null
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
            let ids = this.selectionIds.map(it => it.id);
            this.deleteOrders(ids);
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
        },
        formatAddress(address) {
            let addressline = address.first_name + ',' + address.address_line_1;
            if (address.address_line_2) {
                addressline += ' ' + address.address_line_2;
            }

            if (address.city) {
                addressline += ',' + address.city;
            }

            if (address.state) {
                addressline += ',' + address.state;
            }

            if (address.postalcode) {
                addressline += ',' + address.postalcode;
            }

            return addressline;
        },
        onPrint(order) {
            this.$confirm('是否打印订单?', '提示', {
                type: 'warning'
            }).then(() => {
                ApiService.get('/orders/' + order.id + '/print').then(response => {
                    this.$message.success('Order print success');
                }).catch(reason => {
                    this.$message.error(reason.message);
                });
            }).catch(() => {

            });
        }
    },
    mounted() {
        this.fetchList();
        this.interval = setInterval(() => {
            this.fetchList();
        }, 60000);
    },
}
</script>

<style scoped>

</style>
