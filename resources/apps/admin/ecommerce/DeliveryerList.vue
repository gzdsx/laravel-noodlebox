<template>
    <main-layout>
        <div class="d-flex" slot="header">
            <h2 class="flex-grow-1">配送员管理</h2>
            <div>
                <el-button type="primary" size="small" @click="onShowAdd">新增配送员</el-button>
            </div>
        </div>
        <section class="page-section">
            <el-table :data="dataList" :loading="loading" @selection-change="onSelectionChange">
                <el-table-column width="45" type="selection"/>
                <el-table-column :label="$t('user.avatar')" width="70">
                    <template slot-scope="scope">
                        <featured-image :src="scope.row.image" width="60px" height="60px" :alt="$t('user.avatar')"/>
                    </template>
                </el-table-column>
                <el-table-column prop="name" :label="$t('kefu.name')"/>
                <el-table-column prop="phone" width="200" :label="$t('kefu.phone')"/>
                <el-table-column prop="status" width="200" :label="$t('状态')"/>
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
            <el-form label-width="80px" style="width: 500px;">
                <el-form-item label="头像">
                    <div class="img-80" @click="showPicker=true">
                        <featured-image :src="deliveryer.image"/>
                    </div>
                </el-form-item>
                <el-form-item :label="$t('kefu.name')">
                    <el-input size="medium" v-model="deliveryer.name"/>
                </el-form-item>
                <el-form-item :label="$t('kefu.phone')">
                    <el-input size="medium" v-model="deliveryer.phone"/>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" size="medium" class="w100" @click="onSubmit">{{ $t('common.submit') }}
                    </el-button>
                </el-form-item>
            </el-form>
        </el-dialog>
        <media-dialog v-model="showPicker" @confirm="onSelectImage"/>
    </main-layout>
</template>

<script>
import ApiService from "../utils/ApiService";
import Pagination from "../mixins/Pagination";

export default {
    name: "DeliveryerList",
    mixins: [Pagination],
    data() {
        return {
            deliveryer: {},
            showDialog: false,
            showPicker: false
        }
    },
    methods: {
        listApi() {
            return '/deliveryers';
        },
        resetData() {
            this.deliveryer = {};
        },
        onDelete() {
            let ids = this.selectionIds.map((d) => d.id);
            this.$confirm(this.$t('common.delete_tips'), this.$t('common.delete_confirm'), {
                type: 'warning'
            }).then(() => {
                ApiService.delete('/deliveryers/batch', {data: {ids}}).then(() => {
                    this.fetchList();
                });
            });
        },
        onSubmit() {
            let {deliveryer} = this;
            if (!deliveryer.name) {
                this.$message.error(this.$t('kefu.name_required'));
                return false;
            }
            if (!deliveryer.phone) {
                this.$message.error(this.$t('kefu.phone_required'));
                return false;
            }

            if (deliveryer.id) {
                ApiService.put('/deliveryers/' + deliveryer.id, {deliveryer}).then(() => {
                    this.resetData();
                    this.fetchList();
                    this.showDialog = false;
                    this.$message.success(this.$t('kefu.updated'));
                });
            } else {
                ApiService.post('/deliveryers', {deliveryer}).then(() => {
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
            this.deliveryer = d;
            this.showDialog = true;
        },
        onSelectImage(m) {
            this.deliveryer.image = m.src;
        }
    },
    mounted() {
        this.fetchList();
    },
}
</script>

<style scoped>

</style>
