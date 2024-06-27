<template>
    <main-layout>
        <div class="d-flex" slot="header">
            <h2>收银台账</h2>
        </div>

        <div class="page-section">
            <div class="form-inline">
                <el-form :inline="true">
                    <el-form-item label="日期">
                        <el-date-picker
                                v-model="params.date"
                                type="date"
                                value-format="yyyy-MM-dd"
                                placeholder="选择日期">
                        </el-date-picker>
                    </el-form-item>
                    <el-form-item>
                        <el-button size="medium" type="primary" @click="onSearch">查询</el-button>
                    </el-form-item>
                </el-form>
            </div>
        </div>

        <div class="page-section">
            <el-table :data="dataList" @selection-change="onSelectionChange">
                <el-table-column width="45" type="selection"/>
                <el-table-column prop="pos_base_amount" width="120" label="POS底金"/>
                <el-table-column prop="shipping_total" width="120" label="配送费"/>
                <el-table-column prop="cash_total" width="120" label="现金收入"/>
                <el-table-column prop="online_total" width="120" label="在线收入"/>
                <el-table-column prop="card_total" width="120" label="卡收入"/>
                <el-table-column prop="total" width="120" label="总收入"/>
                <el-table-column prop="refund_total" width="120" label="退款"/>
                <el-table-column prop="cash_profit_total" width="120" label="现金实收"/>
                <el-table-column prop="notes" label="备注"/>
                <el-table-column prop="created_at" width="170" label="结算时间"/>
            </el-table>
            <div class="table-edit-footer">
                <el-button size="small" type="primary" :disabled="selectionIds.length===0" @click="onDelete">
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
    </main-layout>
</template>

<script>
import ApiService from "../utils/ApiService";
import Pagination from "../mixins/Pagination";

export default {
    name: "CashierTransaction",
    mixins: [Pagination],
    data() {
        return {
            params: {
                date: null
            },
        }
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
            this.$confirm('此操作将永久删除所选记录, 是否继续?', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
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
