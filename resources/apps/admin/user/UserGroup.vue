<template>
    <main-layout>
        <div class="d-flex" slot="header">
            <div class="header-left">
                <h2>{{ $t('user.group') }}</h2>
            </div>
            <div>
                <el-button size="small" type="primary" @click="onShowAdd">{{ $t('user.add_group') }}</el-button>
            </div>
        </div>

        <div class="page-section">
            <el-table :data="dataList" :loading="loading" @selection-change="onSelectionChange">
                <el-table-column width="45" type="selection"/>
                <el-table-column prop="gid" width="60" label="GID"/>
                <el-table-column prop="name" :label="$t('user.group_name')" width="200"/>
                <el-table-column prop="credits" :label="$t('user.credits_lower')" width="200"/>
                <el-table-column prop="memo" :label="$t('common.notes')"/>
                <el-table-column :label="$t('common.option')" width="80" align="right">
                    <template slot-scope="scope">
                        <a @click="onShowEdit(scope.row)">{{ $t('common.edit') }}</a>
                    </template>
                </el-table-column>
            </el-table>
            <div class="table-edit-footer">
                <el-button size="small" type="primary" :disabled="selectionIds.length===0" @click="onDelete">
                    {{ $t('common.batch_delete') }}
                </el-button>
            </div>
        </div>

        <el-dialog width="500px" :title="group.gid ? $t('user.edit_group') : $t('user.new_group')" closeable
                   :visible.sync="showDialog"
                   :close-on-click-modal="false"
                   :close-on-press-escape="false">
            <el-form label-width="80px">
                <el-form-item :label="$t('user.group_name')">
                    <el-input size="medium" v-model="group.name"/>
                </el-form-item>
                <el-form-item :label="$t('user.credits_lower')">
                    <el-input size="medium" v-model="group.credits"/>
                </el-form-item>
                <el-form-item :label="$t('common.notes')">
                    <el-input size="medium" v-model="group.memo"/>
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
import UserService from "../utils/UserService";

export default {
    name: "UserGroup",
    data() {
        return {
            loading: false,
            group: {},
            dataList: [],
            selectionIds: [],
            showDialog: false
        }
    },
    methods: {
        fetchList() {
            this.loading = true;
            UserService.listGroups().then((response) => {
                this.dataList = response.data.items;
                this.loading = false;
            });
        },
        onShowEdit(d) {
            this.group = d;
            this.showDialog = true;
        },
        onShowAdd() {
            this.group = {};
            this.showDialog = true;
        },
        onSubmit() {
            let {group} = this;
            if (!group.name) {
                this.$showToast(this.$t('user.group_name_required'));
                return false;
            }

            if (group.gid) {
                UserService.updateGroup(group.gid, group).then(() => {
                    this.showDialog = false;
                    this.$message.success(this.$t('user.group_updated'));
                    this.fetchList();
                });
            } else {
                UserService.storeGroup(group).then(() => {
                    this.showDialog = false;
                    this.$message.success(this.$t('user.group_saved'));
                    this.fetchList();
                });
            }
        },
        onDelete() {
            let ids = this.selectionIds.map((d) => d.gid);
            this.$confirm(this.$t('common.delete_tips'), this.$t('common.delete_confirm'), {
                type: 'warning'
            }).then(() => {
                UserService.deleteGroup(ids).then(() => {
                    this.fetchList();
                });
            });
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
