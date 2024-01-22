<template>
    <main-layout>
        <div class="d-flex" slot="header">
            <h2 class="flex-grow-1">{{ $t('menu.manage') }}</h2>
            <div>
                <el-button type="primary" size="small" @click="onShowEdit">{{ $t('menu.addnew') }}</el-button>
            </div>
        </div>
        <section class="page-section">
            <el-table :data="dataList" @selection-change="onSelectionChange">
                <el-table-column width="45" type="selection"/>
                <el-table-column prop="id" width="50" label="ID"/>
                <el-table-column prop="name" :label="$t('menu.name')"/>
                <el-table-column width="140" :label="$t('common.option')" align="right">
                    <template slot-scope="scope">
                        <a @click="onShowEdit(scope.row)">{{ $t('common.edit') }}</a>
                        <span>|</span>
                        <router-link :to="'/menu/item/'+scope.row.id">{{ $t('menu.edit_items') }}</router-link>
                    </template>
                </el-table-column>
            </el-table>
            <div class="table-edit-footer">
                <el-button size="small" type="primary" :disabled="selectionIds.length===0" @click="onDelete">
                    {{ $t('batch_delete') }}
                </el-button>
            </div>
        </section>
        <el-dialog :title="$t('menu.edit')" closeable :visible.sync="showDialog" :close-on-click-modal="false"
                   :close-on-press-escape="false">
            <el-form label-width="80px">
                <el-form-item :label="$t('menu.name')">
                    <el-input size="medium" v-model="menu.name"/>
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

export default {
    name: "MenuList",
    data() {
        return {
            menu: {},
            dataList: [],
            showDialog: false,
            selectionIds: [],
        }
    },
    methods: {
        fetchList() {
            ApiService.get('/menus').then(response => {
                this.dataList = response.result.items;
            });
        },
        resetData() {
            this.menu = {};
        },
        onDelete() {
            let ids = this.selectionIds.map((d) => d.id);
            this.$confirm(this.$t('common.delete_tips'), this.$t('common.delete_confirm'), {
                type: 'warning'
            }).then(() => {
                ApiService.delete('/menus/batch', {data: {ids}}).then(() => {
                    this.fetchList();
                });
            });
        },
        onSubmit() {
            let {menu} = this;
            if (!menu.name) {
                this.$message.error(this.$t('menu.name_required'));
                return false;
            }

            if (menu.id) {
                ApiService.put('/menus/' + menu.id, {menu}).then(() => {
                    this.resetData();
                    this.fetchList();
                    this.showDialog = false;
                    this.$message.success(this.$t('menu.updated'));
                });
            } else {
                ApiService.post('/menus', {menu}).then(() => {
                    this.resetData();
                    this.fetchList();
                    this.showDialog = false;
                    this.$message.success(this.$t('menu.saved'));
                });
            }
        },
        onShowAdd() {
            this.resetData();
            this.showDialog = true;
        },
        onShowEdit(d) {
            this.menu = d;
            this.showDialog = true;
        },
        onSelectionChange(val) {
            this.selectionIds = val;
        },
    },
    mounted() {
        this.fetchList();
    },
}
</script>

<style scoped>

</style>
