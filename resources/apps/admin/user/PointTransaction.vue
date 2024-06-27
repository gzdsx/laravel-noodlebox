<template>
    <main-layout>
        <div class="d-flex" slot="header">
            <h2>积分明细</h2>
        </div>

        <div class="page-section">
            <el-table :data="dataList" v-loading="loading" @selection-change="onSelectionChange">
                <el-table-column width="45" type="selection"/>
                <el-table-column prop="user.nickname" width="120" label="用户"/>
                <el-table-column prop="detail" label="明细"/>
                <el-table-column prop="points" width="100" label="积分">
                    <template slot-scope="scope">
                        <span v-if="scope.row.type===1">+{{ scope.row.points }}</span>
                        <span class="el-link el-link--danger" v-else>-{{ scope.row.points }}</span>
                    </template>
                </el-table-column>
                <el-table-column prop="created_at" width="170" label="交易时间" align="right"/>
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
    name: "PointTransaction",
    mixins: [Pagination],
    data() {
        return {
            params: {
                out_trade_no: '',
                detail: '',
                pay_state: '',
                uid: ''
            },
        }
    },
    methods: {
        listApi() {
            return '/users/points/transactions';
        },
        onDelete() {
            let ids = this.selectionIds.map((d) => d.id);
            this.$confirm('此操作将永久删除所选记录, 是否继续?', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning'
            }).then(() => {
                this.loading = true;
                ApiService.delete('/users/points/transactions/batch', {data: {ids}}).then(() => {
                    this.fetchList();
                }).finally(() => {
                    this.loading = false;
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
