<template>
    <el-dialog
            :title="dialogTitle"
            :visible="value"
            :close-on-click-modal="false"
            :close-on-press-escape="false"
            append-to-body
            closeable
            @close="close"
    >
        <el-table :data="variation.options" v-loading="loading" @selection-change="onSelectionChange">
            <el-table-column width="40" type="selection"/>
            <el-table-column label="名称" prop="value"/>
            <el-table-column label="编辑" width="170" align="right">
                <template slot-scope="scope">
                    <a @click="onShowEdit(scope.row)">编辑</a>
                </template>
            </el-table-column>
        </el-table>
        <div class="tablenav tablenav-bottom">
            <el-button size="small" type="primary" :disabled="selectionIds.length === 0" @click="batchDelete">
                批量删除
            </el-button>
            <el-button size="small" @click="onShowAdd">
                添加选项
            </el-button>
        </div>
        <el-dialog
                title="添加选项"
                :visible.sync="showDialog"
                width="40%"
                :close-on-click-modal="false"
                :close-on-press-escape="false"
                closeable
                append-to-body
        >
            <el-form size="medium" label-width="80px" class="w400">
                <el-form-item label="选项名称">
                    <el-input v-model="option.value"/>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="onSubmit">确 定</el-button>
                </el-form-item>
            </el-form>
        </el-dialog>
    </el-dialog>
</template>

<script>
import ApiService from "../utils/ApiService";

export default {
    name: "VariationOptions",
    props: {
        value: false,
        variationId: {
            type: [Number, String],
            default: 0
        }
    },
    data() {
        return {
            variation: {
                options: []
            },
            loading: true,
            showDialog: false,
            selectionIds: [],
            option: {name: ''},
            dialogTitle: ''
        }
    },
    watch: {
        value(val) {
            if (val) this.fetchData();
        }
    },
    methods: {
        close() {
            this.$emit('input', false);
        },
        fetchData() {
            let {variationId} = this;
            this.loading = true;
            ApiService.get(`/products/variations/${variationId}`).then(response => {
                this.variation = response.data;
                this.dialogTitle = this.variation.name + ' Options';
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
            this.option = c;
            this.showDialog = true;
        },
        onSubmit() {
            let {option} = this;
            if (!option.value) {
                this.$message.error('请填写名称');
                return false;
            }

            if (option.id) {
                ApiService.put(`/products/variations/options/${option.id}`, {option}).then(() => {
                    this.resetData();
                    this.fetchData();
                    this.showDialog = false;
                });
            } else {
                ApiService.post('/products/variations/options', {option}).then(() => {
                    this.resetData();
                    this.fetchData();
                    this.showDialog = false;
                });
            }
        },
        resetData() {
            let {variationId} = this;
            this.option = {
                id: 0,
                var_id: variationId,
                value: ''
            }
        },
        batchDelete() {
            let ids = this.selectionIds.map((d) => d.id);
            this.$confirm('此操作将永久删除所选内容, 是否继续?', '提示', {
                type: 'warning'
            }).then(() => {
                ApiService.delete('/products/variations/options/batch', {data: {ids}}).then(() => {
                    this.fetchData();
                });
            });
        },
        onSelectionChange(v) {
            this.selectionIds = v;
        }
    },
    mounted() {

    },
}
</script>

<style scoped>

</style>
