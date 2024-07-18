<template>
    <main-layout>
        <div class="d-flex" slot="header">
            <h2 class="flex-grow-1">{{ $t('snippet.manage') }}</h2>
            <div>
                <el-button type="primary" size="small" @click="onShowAdd">{{ $t('snippet.addnew') }}</el-button>
            </div>
        </div>
        <div class="page-section">
            <el-table :data="dataList" @selection-change="onSelectionChange">
                <el-table-column width="45" type="selection"/>
                <el-table-column prop="id" width="80" label="ID"/>
                <el-table-column prop="name" :label="$t('common.name')"/>
                <el-table-column prop="created_at" :label="$t('common.created_at')" width="170"/>
                <el-table-column width="80" :label="$t('common.option')" align="right">
                    <template slot-scope="scope">
                        <a @click="onShowEdit(scope.row)">{{ $t('common.edit') }}</a>
                    </template>
                </el-table-column>
            </el-table>
            <div class="tablenav-bottom">
                <div class="table-actions">
                    <el-button size="small" type="primary" :disabled="selectionIds.length===0" @click="onDelete">
                        {{ $t('common.batch_delete') }}
                    </el-button>
                </div>
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

        <el-dialog :title="$t('snippet.edit')" closeable :visible.sync="showDialog" :close-on-click-modal="false"
                   :close-on-press-escape="false" width="750px">
            <el-form label-width="60px">
                <el-form-item :label="$t('common.name')">
                    <el-input size="medium" v-model="snippet.name"/>
                </el-form-item>
                <el-form-item :label="$t('common.content')">
                    <wang-editor height="300" v-model="snippet.content"/>
                </el-form-item>
                <el-form-item :label="$t('common.link')">
                    <el-input size="medium" v-model="snippet.link"/>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" size="medium" class="w100" @click="onSubmit">{{ $t('common.submit') }}
                    </el-button>
                </el-form-item>
            </el-form>
        </el-dialog>
    </main-layout>
</template>

<script>
import ApiService from "../utils/ApiService";
import Pagination from "../mixins/Pagination";

export default {
    name: "SnippetList",
    mixins: [Pagination],
    data() {
        return {
            snippet: {},
            showDialog: false
        }
    },
    methods: {
        listApi() {
            return '/snippets';
        },
        resetData() {
            this.snippet = {};
        },
        onDelete() {
            let ids = this.selectionIds.map((d) => d.id);
            this.$confirm(this.$t('common.delete_tips'), this.$t('common.delete_confirm'), {
                type: 'warning'
            }).then(() => {
                ApiService.delete('/snippets/batch', {data: {ids}}).then(() => {
                    this.fetchList();
                });
            });
        },
        onSubmit() {
            let {snippet} = this;
            if (!snippet.name) {
                this.$message.error(this.$t('snippet.name_required'));
                return false;
            }

            if (snippet.id) {
                ApiService.put('/snippets/' + snippet.id, snippet).then(() => {
                    this.showDialog = false;
                    this.resetData();
                    this.fetchList();
                });
            } else {
                ApiService.post('/snippets', snippet).then(() => {
                    this.showDialog = false;
                    this.resetData();
                    this.fetchList();
                });
            }
        },
        onShowAdd() {
            this.resetData();
            this.showDialog = true;
        },
        onShowEdit(d) {
            this.snippet = d;
            this.showDialog = true;
        },
        onSelectionChange(val) {
            this.selectionIds = val;
        }
    },
    mounted() {
        this.fetchList();
    },
}
</script>

<style scoped>

</style>
