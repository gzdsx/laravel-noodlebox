<template>
    <el-dialog
            title="选择徽章"
            width="60%"
            :visible="value"
            :close-on-click-modal="false"
            :close-on-press-escape="false"
            append-to-body
            closeable
            @close="close"
    >
        <el-table :data="items" @selection-change="onSelectionChange" v-loading="loading">
            <el-table-column width="45" type="selection"/>
            <el-table-column label="图标" width="70">
                <template slot-scope="scope">
                    <featured-image :src="scope.row.icon" fit="contain" custom-class="badge-icon" width="36px" height="36px"/>
                </template>
            </el-table-column>
            <el-table-column prop="name" label="名称"/>
            <el-table-column label="操作选项" width="80">
                <template slot-scope="scope">
                    <i class="el-icon-close" @click="handleDelete(scope.row.id)"></i>
                </template>
            </el-table-column>
        </el-table>
        <el-form :inline="true" size="medium" style="margin-top: 10px;">
            <el-form-item>
                <featured-image :src="badge.icon" width="36px" height="36px" @click="showMediaDialog=true"/>
            </el-form-item>
            <el-form-item>
                <el-input v-model="badge.name" placeholder="请输入名称"/>
            </el-form-item>
            <el-form-item>
                <el-button @click="handleSubmit">Add</el-button>
            </el-form-item>
        </el-form>
        <div slot="footer" class="dialog-footer">
            <el-button size="medium" @click="close">取消</el-button>
            <el-button size="medium" type="primary" @click="handleConfirm">确定</el-button>
        </div>
        <media-dialog v-model="showMediaDialog" @confirm="onChooseImage"/>
    </el-dialog>
</template>

<script>
import ApiService from "../utils/ApiService";

export default {
    name: "BadgePanel",
    props: {
        type: {
            type: String,
            default: 'default'
        },
        value: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            items: [],
            loading: false,
            showMediaDialog: false,
            badge: {},
            selectionIds: []
        }
    },
    watch: {
        value(val) {
            if (val) {
                this.fetchList();
            }
        }
    },
    methods: {
        close() {
            this.$emit('input', false);
        },
        fetchList() {
            const {type} = this;
            this.loading = true;
            ApiService.get('/badges?type=' + type).then(response => {
                this.items = response.data.items;
            }).catch(reason => {

            }).finally(() => {
                this.loading = false;
            });
        },
        onChooseImage(m) {
            this.badge.icon = m.src;
        },
        handleSubmit() {
            let {badge} = this;
            badge.type = this.type;
            this.loading = true;
            ApiService.post('/badges', badge).then(response => {
                this.items.push(response.data);
                this.badge = {};
            }).catch(reason => {
                console.log(reason);
                this.$message.error(reason.message);
            }).finally(() => {
                this.loading = false;
            });
        },
        handleDelete(id) {
            this.$confirm(this.$t('common.delete_tips'), this.$t('common.delete_confirm'), {
                type: 'warning'
            }).then(() => {
                this.loading = true;
                ApiService.delete('/badges/' + id).then(response => {
                    this.items = this.items.filter(item => item.id !== id);
                }).catch(reason => {
                    this.$message.error(reason.message);
                }).finally(() => {
                    this.loading = false;
                });
            });
        },
        handleConfirm(){
            this.$emit('confirm', this.selectionIds);
            this.close();
        },
        onSelectionChange(val) {
            this.selectionIds = val;
        },
    }
}
</script>

<style scoped>

</style>