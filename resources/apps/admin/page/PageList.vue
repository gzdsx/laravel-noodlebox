<template>
    <main-layout>
        <div class="d-flex" slot="header">
            <div class="header-left">
                <h2>{{ $t('page.manage') }}</h2>
            </div>
            <div>
                <router-link to="/page/new">
                    <el-button type="primary" size="small">{{$t('page.addnew')}}</el-button>
                </router-link>
            </div>
        </div>
        <section class="page-section">
            <el-table :data="dataList" @selection-change="onSelectionChange">
                <el-table-column width="45" type="selection"/>
                <el-table-column prop="id" label="ID" width="60"/>
                <el-table-column prop="title" :label="$t('common.title')">
                    <template slot-scope="scope">
                        <a :href="scope.row.url" target="_blank">{{ scope.row.title }}</a>
                    </template>
                </el-table-column>
                <el-table-column prop="user.nickname" width="170" :label="$t('common.author')"/>
                <el-table-column prop="created_at" width="170" :label="$t('common.published_at')"/>
                <el-table-column width="100" align="right" :label="$t('common.option')">
                    <template slot-scope="scope">
                        <router-link :to="'/page/edit/'+scope.row.id">{{ $t('common.edit') }}</router-link>
                        <span>|</span>
                        <a :href="scope.row.url" target="_blank">{{ $t('common.view') }}</a>
                    </template>
                </el-table-column>
            </el-table>
            <div class="table-edit-footer">
                <el-button size="small" type="primary" :disabled="selectionIds.length===0" @click="onDelete">
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
        </section>
    </main-layout>
</template>

<script>
import ApiService from "../utils/ApiService";
import Pagination from "../mixins/Pagination";

export default {
    name: "PageList",
    mixins: [Pagination],
    data() {
        return {
            params: {q: ''}
        }
    },
    methods: {
        listApi() {
            return '/pages';
        },
        onDelete() {
            let ids = this.selectionIds.map((d) => d.id);
            this.$confirm(this.$t('common.delete_tips'), this.$t('common.delete_confirm'), {
                type: 'warning'
            }).then(() => {
                ApiService.delete('/pages/batch', {data: {ids}}).then(() => {
                    this.fetchList();
                });
            });
        }
    },
    mounted() {
        this.fetchList();
    },
}
</script>

<style scoped>

</style>
