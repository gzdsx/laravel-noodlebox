<template>
    <main-layout>
        <div class="d-flex" slot="header">
            <div class="header-left">
                <h2>{{ $t('block.manage') }}</h2>
            </div>
            <div>
                <el-button type="primary" size="small" @click="onShowAdd">{{ $t('block.addnew') }}</el-button>
            </div>
        </div>

        <section class="page-section">
            <el-table :data="dataList" v-loading="loading" @selection-change="onSelectionChange">
                <el-table-column width="45" type="selection"/>
                <el-table-column prop="id" width="50" label="ID"/>
                <el-table-column width="200" :label="$t('block.name')">
                    <template slot-scope="scope">
                        <a @click="onShowEdit(scope.row)">{{ scope.row.name }}</a>
                    </template>
                </el-table-column>
                <el-table-column prop="description" :label="$t('block.notes')"/>
                <el-table-column width="120" :label="$t('common.option')" align="right">
                    <template slot-scope="scope">
                        <router-link :to="'/block/edit/'+scope.row.id">{{ $t('block.edit_item') }}</router-link>
                    </template>
                </el-table-column>
            </el-table>
            <div class="tablenav-bottom">
                <div class="flex-fill">
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

        <el-dialog :title="$t('block.edit')" closeable :visible.sync="showDialog" :close-on-click-modal="false"
                   :close-on-press-escape="false">
            <el-form label-width="80px">
                <el-form-item :label="$t('block.name')">
                    <el-input size="medium" class="w500" v-model="block.name"/>
                </el-form-item>
                <el-form-item :label="$t('block.notes')">
                    <el-input type="textarea" rows="5" class="w500" v-model="block.description"/>
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
    name: "BlockList",
    mixins: [Pagination],
    data() {
        return {
            block: {},
            showDialog: false
        }
    },
    methods: {
        listApi() {
            return '/blocks';
        },
        resetData() {
            this.block = {};
        },
        onDelete() {
            let ids = this.selectionIds.map((d) => d.id);
            this.$confirm(this.$t('common.delete_tips'), this.$t('common.delete_confirm'), {
                type: 'warning'
            }).then(() => {
                ApiService.delete('/blocks/batch', {data: {ids}}).then(() => {
                    this.fetchList();
                });
            });
        },
        onSubmit() {
            let {block} = this;
            if (!block.name) {
                this.$message.error(this.$t('block.name_required'));
                return false;
            }

            if (block.id) {
                ApiService.put('/blocks/' + block.id, {block}).then(() => {
                    this.resetData();
                    this.fetchList();
                    this.showDialog = false;
                    this.$message.success(this.$t('block.updated'));
                });
            } else {
                ApiService.post('/blocks', {block}).then(response => {
                    this.resetData();
                    this.fetchList();
                    this.showDialog = false;
                    this.$message.success(this.$t('block.saved'));
                });
            }
        },
        onShowAdd() {
            this.resetData();
            this.showDialog = true;
        },
        onShowEdit(d) {
            this.block = d;
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
