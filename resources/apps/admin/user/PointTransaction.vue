<template>
    <main-layout>
        <div class="d-flex" slot="header">
            <h2>{{$t('transaction.points_title')}}</h2>
        </div>

        <div class="page-section">
            <el-table :data="dataList" v-loading="loading" @selection-change="onSelectionChange">
                <el-table-column width="45" type="selection"/>
                <el-table-column prop="user.nickname" width="120" :label="$t('common.user')"/>
                <el-table-column prop="detail" :label="$t('transaction.detail')"/>
                <el-table-column prop="points" width="100" :label="$t('transaction.points')">
                    <template slot-scope="scope">
                        <span v-if="scope.row.type===1">+{{ scope.row.points }}</span>
                        <span class="el-link el-link--danger" v-else>-{{ scope.row.points }}</span>
                    </template>
                </el-table-column>
                <el-table-column prop="created_at" width="170" label="交易时间" align="right"/>
            </el-table>
            <div class="table-edit-footer">
                <el-button size="small"
                           type="primary"
                           :disabled="selectionIds.length===0"
                           @click="onDelete"
                           v-if="userInfo.capability==='administrator'"
                >
                    {{$t('common.batch_delete')}}
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
    computed: {
        userInfo() {
            return this.$store.state.userInfo;
        },
    },
    methods: {
        listApi() {
            return '/users/points/transactions';
        },
        onDelete() {
            let ids = this.selectionIds.map((d) => d.id);
            this.$confirm(this.$t('common.delete_tips'), this.$t('common.delete_confirm'), {
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
