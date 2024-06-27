<template>
    <main-layout>
        <div class="d-flex" slot="header">
            <h2 class="flex-grow-1">POS机管理</h2>
            <div>
                <el-button type="primary" size="small" @click="onShowAdd">新增POS</el-button>
            </div>
        </div>
        <section class="page-section">
            <el-table :data="dataList" :loading="loading" @selection-change="onSelectionChange">
                <el-table-column width="45" type="selection"/>
                <el-table-column prop="name" label="名称"/>
                <el-table-column prop="base_amount" width="200" label="底金"/>
                <el-table-column width="100" label="Status">
                    <template slot-scope="scope">
                        <el-tag :type="scope.row.deliveryer ?'success':'danger'">{{
                            scope.row.deliveryer ? 'Inuse' : 'Idle'
                            }}</el-tag>
                    </template>
                </el-table-column>
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
                    <el-button size="small" type="info" @click="showSettlement=true">收银机结算</el-button>
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
        <el-dialog title="编辑POS" closeable :visible.sync="showDialog" :close-on-click-modal="false"
                   :close-on-press-escape="false">
            <el-form size="medium" label-width="120px" style="width: 400px;">
                <el-form-item label="名称">
                    <el-input v-model="model.name"/>
                </el-form-item>
                <el-form-item label="底金">
                    <el-input v-model="model.base_amount"/>
                </el-form-item>
                <el-form-item label="状态">
                    <el-select v-model="model.status">
                        <el-option label="使用中" value="inuse"/>
                        <el-option label="空闲中" value="idle"/>
                    </el-select>
                </el-form-item>
                <el-form-item label="前台收银机">
                    <el-switch v-model="model.is_cashier" :inactive-value="0" :active-value="1"/>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" class="w100" @click="onSubmit">{{ $t('common.submit') }}
                    </el-button>
                </el-form-item>
            </el-form>
        </el-dialog>
        <dialog-cashier-settlement v-model="showSettlement"/>
    </main-layout>
</template>

<script>
import ApiService from "../utils/ApiService";
import Pagination from "../mixins/Pagination";
import DialogCashierSettlement from "./DialogCashierSettlement.vue";

export default {
    name: "PosMachineList",
    components: {DialogCashierSettlement},
    mixins: [Pagination],
    data() {
        return {
            model: {},
            showDialog: false,
            showSettlement: false
        }
    },
    methods: {
        listApi() {
            return '/pos-machines';
        },
        resetData() {
            this.model = {
                name: '',
                base_amount: 0,
                sort_num: 0,
                is_cashier: 0,
                status: 'inuse'
            };
        },
        onDelete() {
            let ids = this.selectionIds.map((d) => d.id);
            this.$confirm(this.$t('common.delete_tips'), this.$t('common.delete_confirm'), {
                type: 'warning'
            }).then(() => {
                ApiService.delete('/pos-machines/batch', {data: {ids}}).then(() => {
                    this.fetchList();
                });
            });
        },
        onSubmit() {
            let {model} = this;
            if (!model.name) {
                this.$message.error(this.$t('kefu.name_required'));
                return false;
            }

            if (model.id) {
                ApiService.put('/pos-machines/' + model.id, model).then(() => {
                    this.resetData();
                    this.fetchList();
                    this.showDialog = false;
                    this.$message.success('资料已更新');
                });
            } else {
                ApiService.post('/pos-machines', model).then(() => {
                    this.resetData();
                    this.fetchList();
                    this.showDialog = false;
                    this.$message.success('信息保存成功');
                });
            }
        },
        onShowAdd() {
            this.resetData();
            this.showDialog = true;
        },
        onShowEdit(d) {
            this.model = d;
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
