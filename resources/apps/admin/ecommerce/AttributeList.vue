<template>
    <main-layout>
        <div class="d-flex" slot="header">
            <h2 class="flex-grow-1">产品型号</h2>
            <div class="header-right">
                <el-button type="primary" size="small" @click="onShowAdd">添加型号</el-button>
            </div>
        </div>

        <section class="page-section">
            <el-table :data="dataList" v-loading="loading" @selection-change="onSelectionChange">
                <el-table-column width="40" type="selection"/>
                <el-table-column label="名称" width="200">
                    <template slot-scope="scope">
                        <strong>{{ scope.row.name }}</strong>
                    </template>
                </el-table-column>
                <el-table-column label="选项">
                    <template slot-scope="scope">
                        <span>{{ showOptions(scope.row) }}</span>
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
                title="添加型号"
                :visible.sync="showDialog"
                :close-on-click-modal="false"
                :close-on-press-escape="false"
                closeable
        >
            <el-form size="medium" label-width="60px">
                <el-form-item label="名称">
                    <el-input class="w300" v-model="attribute.name"/>
                </el-form-item>
                <el-form-item label="选项">
                    <div class="product-attribute-wrapper">
                        <div class="product-attribute-options" v-if="attribute.options.length">
                            <div class="product-attribute-option" v-for="(o,i) in attribute.options" :key="i">
                                <el-input class="product-attribute-option__input" v-model="o.value"/>
                                <i class="el-icon-error icon-remove" @click="attribute.options.splice(i,1)"></i>
                            </div>
                        </div>
                        <div>
                            <el-button size="small" class="product-attribute-add-item" icon="el-icon-plus"
                                       @click="addOption">添加选项
                            </el-button>
                        </div>
                    </div>
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

export default {
    name: "AttributeList",
    data() {
        return {
            loading: true,
            dataList: [],
            attribute: {name: '', options: []},
            showDialog: false,
            selectionIds: []
        }
    },
    methods: {
        fetchList() {
            ApiService.get('/products/attributes').then(response => {
                this.dataList = response.data.items;
            }).catch(reason => {

            }).finally(() => {
                this.loading = false;
            });
        },
        onShowAdd() {
            this.resetData();
            this.showDialog = true;
        },
        onShowEdit(c) {
            this.attribute = c;
            this.showDialog = true;
        },
        batchDelete() {
            let ids = this.selectionIds.map((d) => d.id);
            this.$confirm('此操作将永久删除所选信息, 是否继续?', '提示', {
                type: 'warning'
            }).then(() => {
                ApiService.delete('/products/attributes/batch', {data: {ids}}).then(() => {
                    this.fetchList();
                });
            });
        },
        onSubmit() {
            let {attribute} = this;
            if (!attribute.name) {
                this.$message.error('请填写名称');
                return false;
            }

            if (attribute.id) {
                ApiService.put('/products/attributes/' + attribute.id, {attribute}).then(() => {
                    this.resetData();
                    this.fetchList();
                    this.showDialog = false;
                    this.$message.success('型号已更新');
                }).catch(reason => {
                    this.$message.error(reason.message);
                });
            } else {
                ApiService.post('/products/attributes', {attribute}).then(() => {
                    this.resetData();
                    this.fetchList();
                    this.showDialog = false;
                    this.$message.success('型号已保存');
                }).catch(reason => {
                    this.$message.error(reason.message);
                });
            }
        },
        resetData() {
            this.attribute = {
                id: 0,
                name: '',
                options: []
            }
        },
        onSelectionChange(val) {
            this.selectionIds = val;
        },
        addOption() {
            this.attribute.options.push({id: 0, value: ''});
        },
        showOptions(attr) {
            return attr.options.map(o => o.value).join(', ');
        }
    },
    mounted() {
        this.resetData();
        this.fetchList();
    },
}
</script>

<style scoped>

</style>
