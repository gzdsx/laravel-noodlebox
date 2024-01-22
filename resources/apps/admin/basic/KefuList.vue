<template>
    <main-layout>
        <div class="d-flex" slot="header">
            <h2 class="flex-grow-1">{{ $t('kefu.manage') }}</h2>
            <div>
                <el-button type="primary" size="small" @click="onShowAdd">{{ $t('kefu.addnew') }}</el-button>
            </div>
        </div>
        <section class="page-section">
            <el-table :data="dataList" :loading="loading" @selection-change="onSelectionChange">
                <el-table-column width="45" type="selection"/>
                <el-table-column prop="title" :label="$t('kefu.name')"/>
                <el-table-column prop="phone" width="200" :label="$t('kefu.phone')"/>
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
        </section>
        <el-dialog :title="$t('kefu.edit')" closeable :visible.sync="showDialog" :close-on-click-modal="false"
                   :close-on-press-escape="false">
            <el-form label-width="80px">
                <el-form-item :label="$t('kefu.name')">
                    <el-input size="medium" v-model="kefu.title"/>
                </el-form-item>
                <el-form-item :label="$t('kefu.phone')">
                    <el-input size="medium" v-model="kefu.phone"/>
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
    name: "KefuList",
    mixins: [Pagination],
    data() {
        return {
            kefu: {},
            showDialog: false,
        }
    },
    methods: {
        listApi() {
            return '/kefus';
        },
        resetData() {
            this.kefu = {};
        },
        onDelete() {
            let ids = this.selectionIds.map((d) => d.id);
            this.$confirm(this.$t('common.delete_tips'), this.$t('common.delete_confirm'), {
                type: 'warning'
            }).then(() => {
                ApiService.delete('/kefus/batch', {data: {ids}}).then(() => {
                    this.fetchList();
                });
            });
        },
        onSubmit() {
            let {kefu} = this;
            if (!kefu.title) {
                this.$message.error(this.$t('kefu.name_required'));
                return false;
            }
            if (!kefu.phone) {
                this.$message.error(this.$t('kefu.phone_required'));
                return false;
            }

            if (kefu.id) {
                ApiService.put('/kefus/' + kefu.id, {kefu}).then(() => {
                    this.resetData();
                    this.fetchList();
                    this.showDialog = false;
                    this.$message.success(this.$t('kefu.updated'));
                });
            } else {
                ApiService.post('/kefus', {kefu}).then(() => {
                    this.resetData();
                    this.fetchList();
                    this.showDialog = false;
                    this.$message.success(this.$t('kefu.saved'));
                });
            }
        },
        onShowAdd() {
            this.resetData();
            this.showDialog = true;
        },
        onShowEdit(d) {
            this.kefu = d;
            this.showDialog = true;
        },
    },
    mounted() {
        this.fetchList();
    },
}
</script>

<style scoped>

</style>
