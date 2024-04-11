<template>
    <main-layout>
        <div class="d-flex" slot="header">
            <h2 class="flex-grow-1">配送区域</h2>
            <div class="header-right">
                <el-button type="primary" size="small" @click="onShowAdd">新增区域</el-button>
            </div>
        </div>

        <section class="page-section">
            <el-table :data="dataList" v-loading="loading" @selection-change="onSelectionChange">
                <el-table-column width="40" type="selection"/>
                <el-table-column label="名称" width="200">
                    <template slot-scope="scope">
                        <strong>{{ scope.row.title }}</strong>
                    </template>
                </el-table-column>
                <el-table-column label="描述">
                    <template slot-scope="scope">
                        <strong>{{ scope.row.description }}</strong>
                    </template>
                </el-table-column>
                <el-table-column label="费用" width="100">
                    <template slot-scope="scope">
                        <strong>{{ scope.row.fee }}</strong>
                    </template>
                </el-table-column>
                <el-table-column :label="$t('common.edit')" width="100" align="right">
                    <template slot-scope="scope">
                        <a @click="onShowEdit(scope.row)">{{ $t('common.edit') }}</a>
                    </template>
                </el-table-column>
            </el-table>
            <div class="tablenav tablenav-bottom">
                <el-button size="small" type="primary" :disabled="selectionIds.length === 0" @click="batchDelete">
                    {{ $t('common.batch_delete') }}
                </el-button>
            </div>
        </section>

        <el-dialog
                title="编辑配送区域"
                :visible.sync="showDialog"
                :close-on-click-modal="false"
                :close-on-press-escape="false"
                closeable
        >
            <el-form size="medium" label-width="60px">
                <el-form-item label="名称">
                    <el-input class="w300" v-model="zone.title"/>
                </el-form-item>
                <el-form-item label="描述">
                    <el-input class="w300" type="textarea" rows="3" v-model="zone.description"/>
                </el-form-item>
                <el-form-item label="费用">
                    <el-input class="w200" v-model="zone.fee">
                        <span slot="prepend">€</span>
                    </el-input>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="onSubmit">确定</el-button>
                </el-form-item>
            </el-form>
        </el-dialog>
    </main-layout>
</template>

<script>
import ApiService from "../utils/ApiService";
import Pagination from "../mixins/Pagination";

export default {
    name: "ShippingZoneList",
    mixins: [Pagination],
    data() {
        return {
            zone: {title: '', fee: '0.00'},
            showDialog: false,
            selectionIds: []
        }
    },
    methods: {
        listApi() {
            return '/shipping-zones';
        },
        onShowAdd() {
            this.resetData();
            this.showDialog = true;
        },
        onShowEdit(v) {
            this.zone = v;
            this.showDialog = true;
        },
        batchDelete() {
            let ids = this.selectionIds.map((d) => d.id);
            this.$confirm('此操作将永久删除所选信息, 是否继续?', '提示', {
                type: 'warning'
            }).then(() => {
                ApiService.delete('/shipping-zones/batch', {data: {ids}}).then(() => {
                    this.fetchList();
                });
            });
        },
        onSubmit() {
            let {zone} = this;
            if (!zone.title) {
                this.$message.error('请填写名称');
                return false;
            }

            if (zone.id) {
                ApiService.put('/shipping-zones/' + zone.id, {zone}).then(() => {
                    this.resetData();
                    this.fetchList();
                    this.showDialog = false;
                    this.$message.success('信息已更新');
                }).catch(reason => {
                    this.$message.error(reason.message);
                });
            } else {
                ApiService.post('/shipping-zones', {zone}).then(() => {
                    this.resetData();
                    this.fetchList();
                    this.showDialog = false;
                    this.$message.success('信息已保存');
                }).catch(reason => {
                    this.$message.error(reason.message);
                });
            }
        },
        resetData() {
            this.zone = {
                id: 0,
                title: '',
                fee: '0.00'
            }
        },
    },
    mounted() {
        this.resetData();
        this.fetchList();
    },
}
</script>

<style scoped>

</style>
