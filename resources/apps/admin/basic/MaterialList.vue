<template>
    <main-layout>
        <div class="d-flex" slot="header">
            <h2 class="flex-grow-1">{{ $t('material.manage') }}</h2>
            <div>
                <el-button type="primary" size="small" @click="showMediaDialog=true">{{ $t('material.addnew') }}
                </el-button>
            </div>
        </div>

        <div class="page-section">
            <div class="form-inline">
                <div class="form-item">
                    <div class="form-item-label">{{ $t('material.name') }}</div>
                    <div class="form-item-input">
                        <el-input size="medium" class="w200" clearable v-model="params.q" clearable/>
                    </div>
                </div>
                <div class="form-item">
                    <div class="form-item-label">{{ $t('material.user') }}</div>
                    <div class="form-item-input">
                        <el-input size="medium" class="w200" clearable v-model="params.user" clearable/>
                    </div>
                </div>
                <div class="form-item">
                    <div class="form-item-label">{{ $t('material.type') }}</div>
                    <div class="form-item-input">
                        <el-select size="medium" clearable v-model="params.type">
                            <el-option value="" :label="$t('common.all')"/>
                            <el-option v-for="(v,k) in types" :value="k" :label="v" :key="k"/>
                        </el-select>
                    </div>
                </div>
                <div class="form-item">
                    <el-button size="medium" type="primary" @click="onSearch">{{ $t('common.search') }}</el-button>
                </div>
            </div>
        </div>

        <div class="page-section">
            <div class="table-edit-header">
                <el-tabs @tab-click="onClickTab">
                    <el-tab-pane name="" :label="$t('common.all')"/>
                    <el-tab-pane
                            v-for="(v,k) in types"
                            :key="k"
                            :label="v"
                            :name="k"
                    />
                </el-tabs>
            </div>

            <el-table :data="dataList" v-loading="loading" @selection-change="onSelectionChange">
                <el-table-column width="40" type="selection"/>
                <el-table-column :label="$t('material.image')" width="70" align="center">
                    <template slot-scope="scope">
                        <el-image :src="scope.row.thumb" class="img-60" fit="cover"/>
                    </template>
                </el-table-column>
                <el-table-column :label="$t('material.name')">
                    <template slot-scope="scope">
                        <div class="post-column-title">{{ scope.row.name }}</div>
                        <div class="post-column-actions">
                            <a @click="onEdit(scope.row)">{{ $t('common.edit') }}</a>
                            <span>|</span>
                            <a @click="deleteRecords([scope.row.id])">{{ $t('common.delete_forever') }}</a>
                            <span>|</span>
                            <a v-clipboard:copy="scope.row.src"
                               v-clipboard:success="onCopy">{{ $t('common.copy_url') }}</a>
                        </div>
                    </template>
                </el-table-column>
                <el-table-column prop="user.nickname" width="200" :label="$t('material.user')"/>
                <el-table-column prop="formated_size" width="100" :label="$t('material.size')"/>
                <el-table-column prop="created_at" width="170" :label="$t('material.created_at')" align="right"/>
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
        </div>
        <el-dialog :title="$t('material.edit')" closeable :visible.sync="showDialog" :close-on-click-modal="false"
                   :close-on-press-escape="false">
            <el-form label-width="60px">
                <el-form-item :label="$t('material.name')">
                    <el-input size="medium" class="w500" v-model="material.name"/>
                </el-form-item>
                <el-form-item :label="$t('material.description')">
                    <el-input type="textarea" class="w500" rows="5" v-model="material.description"/>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" size="medium" class="w100" @click="onSubmit">{{ $t('common.submit') }}
                    </el-button>
                </el-form-item>
            </el-form>
        </el-dialog>
        <media-dialog v-model="showMediaDialog"/>
    </main-layout>
</template>

<script>
import MaterialService from "../utils/MaterialService";
import Pagination from "../mixins/Pagination";

export default {
    name: "MaterialList",
    mixins: [Pagination],
    data() {
        return {
            types: {},
            params: {
                q: '',
                user: '',
                type: ''
            },
            material: {},
            showDialog: false,
            showMediaDialog: false
        }
    },
    methods: {
        listApi() {
            return '/materials'
        },
        listParams() {
            return this.params;
        },
        deleteRecords(ids) {
            this.$confirm(this.$t('common.delete_tips'), this.$t('common.delete_confirm'), {
                type: 'warning'
            }).then(() => {
                MaterialService.batchDelete(ids).then(() => {
                    this.fetchList();
                });
            });
        },
        onDelete() {
            let ids = this.selectionIds.map((d) => d.id);
            this.deleteRecords(ids);
        },
        onClickTab(tab) {
            this.params.type = tab.name;
            this.onSearch();
        },
        onCopy() {
            this.$message.success(this.$t('common.url_copy_success'));
        },
        onEdit(m) {
            this.material = m;
            this.showDialog = true;
        },
        onSubmit() {
            let {id, name, description} = this.material;
            if (!name) {
                this.$message.error(this.$t('material.name_required'));
                return false;
            }

            MaterialService.update(id, {name, description}).then(() => {
                this.showDialog = false;
                this.$message.success(this.$t('material.updated'));
            });
        },
        fetchTypes() {
            MaterialService.get('types').then(res => {
                this.types = res.data;
            });
        }
    },
    mounted() {
        this.fetchList();
        this.fetchTypes();
    },
}
</script>

<style scoped>

</style>
