<template>
    <main-layout>
        <div class="d-flex" slot="header">
            <div class="header-left">
                <h2>{{ $t('link.manage') }}</h2>
            </div>
            <div>
                <el-button type="primary" size="medium" @click="onShowAdd">{{ $t('link.addnew') }}</el-button>
            </div>
        </div>
        <section class="page-section">
            <el-table :data="dataList" @selection-change="onSelectionChange">
                <el-table-column width="45" type="selection"/>
                <el-table-column :label="$t('common.image')" width="70">
                    <template slot-scope="scope">
                        <el-image class="img-50" fit="cover" :src="scope.row.image"
                                  @click="onChangeImage(scope.row)"/>
                    </template>
                </el-table-column>
                <el-table-column prop="title" :label="$t('link.name')">
                    <template slot-scope="scope">
                        <a :href="scope.row.url" target="_blank">{{ scope.row.title }}</a>
                    </template>
                </el-table-column>
                <el-table-column prop="url" :label="$t('common.link')"/>
                <el-table-column :label="$t('common.option')" width="80" align="right">
                    <template slot-scope="scope">
                        <a @click="onShowEdit(scope.row)">{{ $t('common.edit') }}</a>
                    </template>
                </el-table-column>
            </el-table>
            <div class="tablenav tablenav-bottom">
                <el-button size="small" type="primary" :disabled="selectionIds.length===0" @click="onDelete">
                    {{ $t('common.batch_delete') }}
                </el-button>
            </div>
        </section>

        <el-dialog :visible.sync="showDialog" width="45%" :title="$t('link.edit')" :close-on-click-modal="false"
                   :close-on-press-escape="false">
            <el-form label-width="80px">
                <el-form-item :label="$t('link.logo')">
                    <div @click="showPicker=true">
                        <el-image :src="link.image" fit="cover" class="w80 h80" v-if="link.image"/>
                        <div class="img-60 img-placeholder" v-else></div>
                    </div>
                </el-form-item>
                <el-form-item :label="$t('link.name')">
                    <el-input v-model="link.title" size="medium" class="w300"/>
                </el-form-item>
                <el-form-item :label="$t('link.url')">
                    <el-input v-model="link.url" size="medium" class="w300"/>
                </el-form-item>
                <el-form-item :label="$t('common.sort')">
                    <el-input v-model="link.sort_num" size="medium" class="w300"/>
                </el-form-item>
                <el-form-item>
                    <el-button size="medium" type="primary" @click="onSubmit" class="w100">{{ $t('common.submit') }}
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
    name: "LinkList",
    data() {
        return {
            cate_id: 0,
            link: {},
            dataList: [],
            categoryList: [
                {
                    id: 0,
                    title: this.$t('all')
                }
            ],
            selectionIds: [],
            showDialog: false,
            showPicker: false
        }
    },
    mounted() {
        this.fetchList();
        this.fetchCategoryList();
    },
    methods: {
        fetchList() {
            let {cate_id} = this;
            ApiService.get('/links?cate_id=' + cate_id).then(response => {
                this.dataList = response.result.items;
            });
        },
        fetchCategoryList() {
            ApiService.get('/links?type=category').then(response => {
                this.categoryList = this.categoryList.concat(response.result.items);
            });
        },
        onSelectionChange(val) {
            this.selectionIds = val;
        },
        onDelete() {
            let ids = this.selectionIds.map((d) => d.id);
            this.$confirm(this.$t('common.delete_tips'), this.$t('common.delete_confirm'), {
                type: 'warning'
            }).then(() => {
                ApiService.delete('/links/batch', {data: {ids}}).then(() => {
                    this.fetchList();
                });
            });
        },
        onShowAdd() {
            this.link = {};
            this.showDialog = true;
        },
        onShowEdit(link) {
            this.link = link;
            this.showDialog = true;
        },
        onSubmit() {
            let {link} = this;
            if (!link.title) {
                this.$message.error(this.$t('link.name_required'));
                return false;
            }

            if (!link.url) {
                this.$message.error(this.$t('link.url_required'));
                return false;
            }

            if (link.id) {
                ApiService.put('/links/' + link.id, {link}).then(() => {
                    this.$message.success(this.$t('link.updated'));
                    this.showDialog = false;
                    this.fetchList();
                });
            } else {
                ApiService.post('/links', {link}).then(() => {
                    this.$message.success(this.$t('link.saved'));
                    this.showDialog = false;
                    this.fetchList();
                });
            }
        },
        onChooseImage(m) {
            let {link} = this;
            link.image = m.url;
        },
        onClickTab(t) {
            this.cate_id = t.name;
            this.fetchList();
        },
        onRemoveTab(t) {

        },
    }
}
</script>

<style scoped>

</style>
