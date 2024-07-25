<template>
    <main-layout>
        <div class="d-flex" slot="header">
            <h2>{{ $t('transaction.deliveryer_title') }}</h2>
        </div>

        <div class="page-section">
            <div class="form-inline">
                <el-form :inline="true">
                    <el-form-item :label="$t('common.date')">
                        <el-date-picker
                            size="medium"
                            v-model="params.date"
                            type="date"
                            value-format="yyyy-MM-dd"
                            :placeholder="$t('common.please_select')">
                        </el-date-picker>
                    </el-form-item>
                    <el-form-item>
                        <el-button size="medium" type="primary" @click="onSearch">{{ $t('common.search') }}</el-button>
                    </el-form-item>
                </el-form>
            </div>
        </div>

        <div class="page-section">
            <el-table :data="dataList" @selection-change="onSelectionChange">
                <el-table-column width="45" type="selection"/>
                <el-table-column :label="$t('transaction.deliveryer')">
                    <template slot-scope="scope">
                        <div class="post-column-title">
                            <a @click="currentTransaction=scope.row;showTransaction=true">{{
                                    scope.row.deliveryer.name
                                }}</a>
                        </div>
                    </template>
                </el-table-column>
                <el-table-column prop="base_amount" :label="$t('transaction.base_amount')"/>
                <el-table-column prop="shipping_total" width="120" :label="$t('transaction.shipping_total')"/>
                <el-table-column prop="online_total" width="120" :label="$t('transaction.online_total')"/>
                <el-table-column prop="card_total" width="120" :label="$t('transaction.card_total')"/>
                <el-table-column prop="cash_total" width="120" :label="$t('transaction.cash_total')"/>
                <el-table-column prop="cost_total" width="120" :label="$t('transaction.cost_total')"/>
                <el-table-column prop="actual_total" width="120" :label="$t('transaction.actual_total')"/>
                <el-table-column width="80" label="Status">
                    <template slot-scope="scope">
                        <el-tag v-if="scope.row.status === 'settled'" type="success">
                            {{ $t('transaction.status_options.settled') }}
                        </el-tag>
                        <el-tag v-else type="danger">{{ $t('transaction.status_options.pending') }}</el-tag>
                    </template>
                </el-table-column>
                <el-table-column prop="created_at" width="170" :label="$t('transaction.created_at')" fixed="right"/>
                <el-table-column width="80" :label="$t('common.action')" fixed="right">
                    <template slot-scope="scope">
                        <a :href="scope.row.links.invoice.href" target="_blank">{{ $t('common.print') }}</a>
                    </template>
                </el-table-column>
            </el-table>
            <div class="table-edit-footer">
                <el-button size="small"
                           type="primary"
                           :disabled="selectionIds.length===0"
                           @click="onDelete"
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
        <dialog-deliveryer-bill
            :transaction="currentTransaction"
            :driver-name="currentTransaction.deliveryer.name"
            v-model="showTransaction"
            @change="fetchList"
        />
    </main-layout>
</template>

<script>
import ApiService from "../utils/ApiService";
import Pagination from "../mixins/Pagination";
import DialogDeliveryerBill from "./DialogDeliveryerBill.vue";

export default {
    name: "DeliveryerTransaction",
    components: {DialogDeliveryerBill},
    mixins: [Pagination],
    data() {
        return {
            params: {
                date: null
            },
            showTransaction: false,
            currentTransaction: {
                deliveryer:{}
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
            return '/deliveryers/0/transactions';
        },
        listParams() {
            return this.params;
        },
        onDelete() {
            let ids = this.selectionIds.map((d) => d.id);
            this.$confirm(this.$t('common.delete_tips'), this.$t('common.delete_confirm'), {
                type: 'warning'
            }).then(() => {
                ApiService.delete('/deliveryers/0/transactions/batch', {data: {ids}}).then(() => {
                    this.fetchList();
                });
            });
        },
        onClickTab(tab) {
            this.params.pay_state = tab.name;
            this.onSearch();
        }
    },
    mounted() {
        this.fetchList();
    },
}
</script>

<style scoped>

</style>
