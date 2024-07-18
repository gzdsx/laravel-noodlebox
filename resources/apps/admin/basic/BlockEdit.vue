<template>
    <main-layout>
        <div class="d-flex" slot="header">
            <div class="header-left">
                <el-breadcrumb separator-class="el-icon-arrow-right">
                    <el-breadcrumb-item to="/block/list">{{ $t('block.manage') }}</el-breadcrumb-item>
                    <el-breadcrumb-item>{{ block.name }}</el-breadcrumb-item>
                </el-breadcrumb>
            </div>
            <div>
                <el-button type="primary" size="small" @click="onShowAdd">{{ $t('block.new_item') }}</el-button>
            </div>
        </div>

        <div class="page-section">
            <el-table :data="block.items" v-loading="loading" sortable="true" @selection-change="onSelectionChange">
                <el-table-column width="45" type="selection"/>
                <el-table-column width="70" :label="$t('common.image')">
                    <template slot-scope="scope">
                        <el-image :src="scope.row.image" class="img-50" fit="cover"/>
                    </template>
                </el-table-column>
                <el-table-column prop="title" width="200" :label="$t('common.title')"/>
                <el-table-column prop="url" :label="$t('common.link')"/>
                <el-table-column prop="sort_num" :label="$t('common.sort')" align="center" width="100"/>
                <el-table-column width="80" :label="$t('common.option')" align="right">
                    <template slot-scope="scope">
                        <a @click="onShowEdit(scope.row)">{{ $t('common.edit') }}</a>
                    </template>
                </el-table-column>
            </el-table>
            <div class="tablenav-bottom">
                <el-button size="small" type="primary" :disabled="selectionIds.length===0" @click="onDelete">
                    {{ $t('common.batch_delete') }}
                </el-button>
            </div>
        </div>

        <el-dialog :title="$t('block.edit_item')" closeable :visible.sync="showDialog" :close-on-click-modal="false"
                   :close-on-press-escape="false">
            <el-form label-width="60px" size="medium">
                <el-form-item :label="$t('common.image')">
                    <div class="h80 w160" @click="showPicker=true">
                        <featured-image :src="item.image"/>
                    </div>
                </el-form-item>
                <el-form-item :label="$t('common.title')">
                    <el-input v-model="item.title"/>
                </el-form-item>
                <el-form-item :label="$t('common.description')">
                    <el-input type="textarea" rows="5" v-model="item.description"/>
                </el-form-item>
                <el-form-item :label="$t('common.link')">
                    <el-input v-model="item.url"/>
                </el-form-item>
                <el-form-item :label="$t('common.sort')">
                    <el-input class="w200" v-model="item.sort_num"/>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" size="medium" class="w100" :disabled="submiting" @click="onSubmit">
                        {{ $t('common.submit') }}
                    </el-button>
                </el-form-item>
            </el-form>
        </el-dialog>
        <media-dialog v-model="showPicker" @confirm="onChooseImage"/>
    </main-layout>
</template>

<script>
import ApiService from "../utils/ApiService";

export default {
    name: "BlockItem",
    data() {
        return {
            loading: true,
            item: {},
            block: {},
            selectionIds: [],
            showDialog: false,
            showPicker: false,
            submiting: false
        }
    },
    methods: {
        fetchData() {
            let {id} = this.$route.params;
            ApiService.get('/blocks/' + id).then(response => {
                this.block = response.data;
            }).catch(reason => {
                this.$message.error(reason.message);
            }).finally(() => {
                this.loading = false;
            });
        },
        resetData() {
            let {id} = this.$route.params;
            this.item = {block_id: id, sort_num: 0};
        },
        onDelete() {
            let ids = this.selectionIds.map((d) => d.id);
            this.$confirm(this.$t('common.delete_tips'), this.$t('common.delete_confirm'), {
                type: 'warning'
            }).then(() => {
                ApiService.delete('/blocks/items/batch', {data: {ids}}).then(() => {
                    this.fetchData();
                });
            });
        },
        onSubmit() {
            let {item} = this;
            if (!item.title) {
                this.$message.error(this.$t('block.title_required'));
                return false;
            }

            this.submiting = true;
            if (item.id) {
                ApiService.put('/blocks/items/' + item.id, item).then(() => {
                    this.resetData();
                    this.fetchData();
                    this.showDialog = false;
                    this.$message.success(this.$t('block.item_updated'));
                }).finally(() => {
                    this.submiting = false;
                });
            } else {
                ApiService.post('/blocks/items', item).then(() => {
                    this.resetData();
                    this.fetchData();
                    this.showDialog = false;
                    this.$message.success(this.$t('block.item_saved'));
                }).finally(() => {
                    this.submiting = false;
                });
            }
        },
        onShowAdd() {
            this.resetData();
            this.showDialog = true;
        },
        onShowEdit(d) {
            this.item = d;
            this.showDialog = true;
        },
        onSelectionChange(val) {
            this.selectionIds = val;
        },
        onChooseImage(m) {
            this.item.image = m.src;
        },
    },
    mounted() {
        this.fetchData();
    },
}
</script>

<style scoped>

</style>
