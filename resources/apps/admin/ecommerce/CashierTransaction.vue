<template>
    <main-layout>
        <div class="d-flex" slot="header">
            <h2>{{ $t('transaction.cashier_title') }}</h2>
        </div>

        <div class="page-section">
            <div class="form-inline">
                <el-form :inline="true">
                    <el-form-item :label="$t('common.date')">
                        <el-date-picker
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
                <el-table-column prop="user.nickname" label="Cashier"/>
                <el-table-column prop="base_amount" :label="$t('transaction.float')"/>
                <el-table-column prop="shipping_total" :label="$t('transaction.shipping_total')"/>
                <el-table-column prop="online_total" :label="$t('transaction.online_total')"/>
                <el-table-column prop="card_total" :label="$t('transaction.card_total')"/>
                <el-table-column prop="cash_total" :label="$t('transaction.cash_total')"/>
                <el-table-column prop="cost_total" :label="$t('transaction.cost_total')" width="100"/>
                <el-table-column prop="refund_total" :label="$t('transaction.refund_total')"/>
                <el-table-column prop="actual_total" :label="$t('transaction.actual_total')"/>
                <el-table-column prop="total" :label="$t('transaction.total')" fixed="right"/>
                <el-table-column prop="net_total" :label="$t('transaction.net_total')" fixed="right"/>
                <el-table-column :label="$t('common.status')" fixed="right" width="100">
                    <template slot-scope="scope">
                        <div @click="currentTransaction=scope.row;showDialog=true;">
                            <el-tag type="success" v-if="scope.row.status==='settled'">Settled</el-tag>
                            <el-tag type="warnning" v-else>Pending</el-tag>
                        </div>
                    </template>
                </el-table-column>
                <el-table-column prop="created_at" width="170" fixed="right" :label="$t('transaction.created_at')"/>
                <el-table-column :label="$t('common.option')" width="100" fixed="right">
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
        <dialog-cashier-transaction v-model="showDialog" :billing="currentTransaction" @change="fetchList"/>
    </main-layout>
</template>

<script>
import ApiService from "../utils/ApiService";
import Pagination from "../mixins/Pagination";
import DialogCashierTransaction from "./DialogCashierTransaction.vue";

export default {
    name: "CashierTransaction",
    components: {DialogCashierTransaction},
    mixins: [Pagination],
    data() {
        return {
            params: {
                date: null
            },
            showDialog: false,
            currentTransaction: {}
        }
    },
    computed: {
        userInfo() {
            return this.$store.state.userInfo;
        },
    },
    methods: {
        listApi() {
            return '/cashier/transactions';
        },
        listParams() {
            return this.params;
        },
        onDelete() {
            let ids = this.selectionIds.map((d) => d.id);
            this.$confirm(this.$t('common.delete_tips'), this.$t('common.delete_confirm'), {
                type: 'warning'
            }).then(() => {
                ApiService.delete('/cashier/transactions/batch', {data: {ids}}).then(() => {
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
