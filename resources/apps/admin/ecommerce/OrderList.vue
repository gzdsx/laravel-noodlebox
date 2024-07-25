<template>
    <main-layout>
        <div class="d-flex" slot="header">
            <h2 class="flex-grow-1">{{ $t('order.manage') }}</h2>
        </div>

        <div class="page-section">
            <el-form :inline="true" size="medium" label-width="80px">
                <el-form-item :label="$t('order.no')">
                    <el-input class="w200" v-model="params.order_no"/>
                </el-form-item>
                <el-form-item label="Driver">
                    <el-select v-model="params.deliveryer" clearable>
                        <el-option
                            v-for="item in deliveryerList"
                            :key="item.id"
                            :label="item.name"
                            :value="item.id"
                        />
                    </el-select>
                </el-form-item>
                <el-form-item label="CreatedV">
                    <el-select v-model="params.created_via" clearable>
                        <el-option
                            v-for="item in ['checkout', 'app','pos']"
                            :key="item"
                            :label="item"
                            :value="item"
                        />
                    </el-select>
                </el-form-item>
                <el-form-item label="PaymentM">
                    <el-select v-model="params.payment_method" clearable>
                        <el-option label="Online" value="Online"/>
                        <el-option label="card" value="Card"/>
                        <el-option label="cash" value="Cash"/>
                        <el-option label="customize" value="Customize"/>
                    </el-select>
                </el-form-item>
                <el-form-item label="Date">
                    <el-date-picker
                        class="w200"
                        type="date"
                        format="yyyy-MM-dd"
                        value-format="yyyy-MM-dd"
                        v-model="params.date"
                        clearable
                    />
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="onSearch">{{ $t('common.search') }}</el-button>
                    <el-button @click="clearSearch">Clear</el-button>
                </el-form-item>
            </el-form>
        </div>

        <div class="page-section" v-loading="loading">
            <div class="table-edit-header">
                <el-tabs @tab-click="onClickTab" value="all">
                    <el-tab-pane :label="$t('common.all')" name="all"/>
                    <el-tab-pane :label="$t('order.status_options.pending')" name="pending"/>
                    <el-tab-pane :label="$t('order.status_options.processing')" name="processing"/>
                    <el-tab-pane :label="$t('order.status_options.delivering')" name="deliverying"/>
                    <el-tab-pane :label="$t('order.status_options.completed')" name="completed"/>
                    <el-tab-pane :label="$t('order.status_options.cancelled')" name="canceled"/>
                </el-tabs>
            </div>
            <el-table :data="dataList" highlight-current-row @selection-change="onSelectionChange">
                <el-table-column width="45" type="selection"/>
                <el-table-column width="200" label="Order">
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
                            <span><a :href="scope.row.links.invoice.href" target="_blank">Invoice</a></span>
                        </div>
                    </template>
                </el-table-column>
                <el-table-column label="Ship to" width="200">
                    <template slot-scope="scope">
                        <div style="line-height: 1.1">
                            <small>{{ formatAddress(scope.row.shipping) }}</small>
                        </div>
                    </template>
                </el-table-column>
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
                <el-table-column width="120" label="Status">
                    <template slot-scope="scope">
                        <el-tag type="success" v-if="scope.row.status==='completed'">{{ scope.row.status|capitalize }}
                        </el-tag>
                        <el-tag type="danger" v-else>{{ scope.row.status|capitalize }}</el-tag>
                    </template>
                </el-table-column>
                <el-table-column label="ShippingM" width="100" prop="shipping_method">
                    <template slot-scope="scope">
                        <div v-if="scope.row.shipping_method=='flat_rate'">
                            <div>Delivery</div>
                            <small>{{ scope.row.shipping_line.zone_title }}</small>
                        </div>
                        <div v-else>
                            Collection
                        </div>
                    </template>
                </el-table-column>
                <el-table-column label="Total" width="80" fixed="right">
                    <template slot-scope="scope">
                        <div>{{ '€' + scope.row.total }}</div>
                        <div style="line-height: 1; word-break: break-word;">
                            <small class="text-danger" v-if="scope.row.payment_method==='card'">
                                {{paymentMap[scope.row.payment_method]}}
                            </small>
                            <small class="text-success" v-else>
                                {{paymentMap[scope.row.payment_method]}}
                            </small>
                        </div>
                    </template>
                </el-table-column>
                <el-table-column label="CreatedV" width="90" prop="created_via" fixed="right"/>
                <el-table-column label="Actions" width="90" align="right" fixed="right">
                    <template slot-scope="scope">
                        <div>
                            <el-button size="mini" type="text" @click="onDispose(scope.row)">{{ $t('order.dispose') }}
                            </el-button>
                        </div>
                        <div>
                            <el-button size="mini" type="text" @click="onPrint(scope.row)">Print</el-button>
                        </div>
                    </template>
                </el-table-column>
            </el-table>
            <div class="table-edit-footer">
                <el-button
                    size="small"
                    type="primary"
                    :disabled="selectionIds.length===0"
                    @click="onBatchDelete"
                    v-if="userInfo.capability==='administrator'"
                >
                    {{ $t('common.batch_delete') }}
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
            pageSize: 40,
            params: {
                order_no: '',
                buyer_name: '',
                status: 'all',
                date: '',
                deliveryer: '',
            },
            showOrderDialog: false,
            currentOrder: {},
            invoceLink: '',
            interval: null,
            dateRange: [],
            deliveryerList: [],
            paymentMap:{
                online:'Pay Online (PayPal & Credit Car)',
                card:'Card Reader(Unpaid)',
                card_reader:'Card Reader(Paid)',
                cash:'Pay Cash',
                customize:'Customize',
            }
        }
    },
    computed: {
        userInfo() {
            return this.$store.state.userInfo;
        },
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
            this.$confirm(this.$t('common.delete_tips'), this.$t('common.delete_confirm'), {
                type: 'warning'
            }).then(() => {
                this.loading = true;
                ApiService.delete('/orders/batch', {data: {ids}}).then(() => {
                    this.dataList = this.dataList.filter(it => !ids.includes(it.id));
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

            return address.formatted_address;
        },
        onPrint(order) {
            this.$confirm(this.$t('order.print_confirm'), this.$t('common.delete_confirm'), {
                type: 'warning'
            }).then(() => {
                ApiService.get('/orders/' + order.id + '/print').then(response => {
                    this.$message.success('Order print success');
                }).catch(reason => {
                    this.$message.error(reason.message);
                });
            }).catch(() => {

            });
        },
        fetchDeliveryerList() {
            ApiService.get('/deliveryers?limit=100').then(response => {
                this.deliveryerList = response.data.items;
            }).catch(reason => {
                this.$message.error(reason.message);
            });
        },
        clearSearch() {
            this.params = {
                order_no: '',
                buyer_name: '',
                status: 'all',
                date: '',
                deliveryer: '',
            };
        }
    },
    mounted() {
        this.fetchList();
        this.fetchDeliveryerList();
        this.interval = setInterval(() => {
            this.fetchList();
        }, 60000);
    },
}
</script>

<style scoped>

</style>
