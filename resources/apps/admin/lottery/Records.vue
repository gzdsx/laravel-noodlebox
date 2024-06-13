<template>
    <main-layout>
        <div class="d-flex" slot="header">
            <h2 class="flex-grow-1">获奖记录</h2>
        </div>

        <section class="page-section">
            <el-table :data="dataList" v-loading="loading" @selection-change="onSelectionChange">
                <el-table-column width="40" type="selection"/>
                <el-table-column label="图片" width="100">
                    <template slot-scope="scope">
                        <featured-image :src="scope.row.image" width="60px" height="60px"/>
                    </template>
                </el-table-column>
                <el-table-column label="奖品">
                    <template slot-scope="scope">
                        <strong>{{ scope.row.name }}</strong>
                    </template>
                </el-table-column>
                <el-table-column prop="user.nickname" label="中奖客户" width="200"/>
                <el-table-column prop="created_at" label="时间" width="170" align="right"/>
            </el-table>
            <div class="tablenav tablenav-bottom">
                <div class="table-actions">
                    <el-button size="small" type="primary" :disabled="selectionIds.length === 0" @click="batchDelete">
                        {{ $t('common.batch_delete') }}
                    </el-button>
                </div>
                <el-pagination
                        background
                        layout="prev, pager, next,total"
                        :total="total"
                        :page-size="pageSize"
                        :current-page="page"
                        @current-change="onPageChange"
                />
            </div>
        </section>
    </main-layout>
</template>

<script>
import Pagination from "../mixins/Pagination";
import ApiService from "../utils/ApiService";

export default {
    name: "Records",
    mixins: [Pagination],
    data() {
        return {}
    },
    methods: {
        listApi() {
            return '/lottery/records';
        },
        batchDelete() {
            let ids = this.selectionIds.map((d) => d.id);
            this.$confirm('此操作将永久删除所选信息, 是否继续?', '提示', {
                type: 'warning'
            }).then(() => {
                this.loading = true;
                ApiService.delete('/lottery/records/batch', {data: {ids}}).then(() => {
                    this.fetchList();
                }).finally(() => {
                    this.loading = false;
                });
            });
        },
    },
    mounted() {
        this.fetchList();
    },
}
</script>

<style scoped>

</style>