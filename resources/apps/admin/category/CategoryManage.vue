<template>
    <main-layout>
        <div class="d-flex" slot="header">
            <h2 class="flex-grow-1">{{ $t('category.manage') }}</h2>
            <div>
                <el-button type="primary" size="small" @click="onShowAdd">{{ $t('category.addnew') }}</el-button>
            </div>
        </div>
        <section class="page-section">
            <table class="dsxui-listtable">
                <thead>
                <tr>
                    <th width="50">ID</th>
                    <th width="50">{{ $t('category.icon') }}</th>
                    <th>{{ $t('category.name') }}</th>
                    <th width="100">{{ $t('category.sort') }}</th>
                    <th width="200" class="text-right">{{ $t('category.option') }}</th>
                </tr>
                </thead>
            </table>
            <category-list-table
                    :categories="categories"
                    :level="0"
                    :on-edit="onShowEdit"
                    :on-delete="onDelete"
                    :on-add-child="onAddChild"
                    :on-increase="onIncrease"
                    :on-decrease="onDecrease"
            />
        </section>
        <el-dialog :title="$t('category.edit')"
                   closeable
                   :visible.sync="showDialog"
                   :close-on-click-modal="false"
                   :close-on-press-escape="false">
            <el-form label-width="80px">
                <el-form-item :label="$t('category.icon')">
                    <div class="img-80" @click="showMediaDialog=true">
                        <el-image :src="category.image" fit="cover" class="img-80" v-if="category.image"/>
                        <div class="img-80 img-placeholder" v-else></div>
                    </div>
                </el-form-item>
                <el-form-item :label="$t('category.name')">
                    <el-input size="medium" class="w300" v-model="category.name"/>
                </el-form-item>
                <el-form-item :label="$t('category.alias')">
                    <el-input size="medium" class="w300" v-model="category.slug"/>
                </el-form-item>
                <el-form-item :label="$t('category.parent')">
                    <el-cascader
                            v-model="category.parent_id"
                            size="medium"
                            class="w300"
                            :clearable="true"
                            :options="cascaderOptions"
                            style="height: 36px;"
                            :placeholder="$t('category.no_parent')"
                            @change="onSascaderChange"
                            @clear="category.parent_id=0"
                    />
                </el-form-item>
                <el-form-item :label="$t('category.sort')">
                    <el-input size="medium" class="w100" v-model="category.sort_num"/>
                </el-form-item>
                <el-form-item :label="$t('category.description')">
                    <el-input size="medium" type="textarea" rows="3" class="w500" v-model="category.description"/>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" size="medium" class="w100" @click="onSubmit">{{ $t('common.submit') }}
                    </el-button>
                </el-form-item>
            </el-form>
        </el-dialog>
        <media-dialog v-model="showMediaDialog" :options="{type:'image'}" @confirm="onChooseImage"/>
    </main-layout>
</template>

<script>
import CategoryService from "../utils/CategoryService";
import CategoryListTable from "./CategoryListTable";
import CategoryOptionList from "./CategoryOptionList";

export default {
    name: "CategoryManage",
    components: {CategoryOptionList, CategoryListTable},
    props: {
        taxonomy: {
            type: String,
            default: 'post'
        }
    },
    data() {
        return {
            categories: [],
            category: {},
            showDialog: false,
            showMediaDialog: false,
            cascaderOptions: []
        }
    },
    watch: {},
    methods: {
        fetchList() {
            let {taxonomy} = this;
            CategoryService.list({taxonomy}).then(response => {
                this.categories = response.data.items;
                this.cascaderOptions = CategoryService.generateCascaderOptions(this.categories);
            });
        },
        onShowEdit(c) {
            this.category = c;
            this.showDialog = true;
            this.cascaderOptions = CategoryService.generateCascaderOptions(this.categories);
        },
        onShowAdd() {
            this.category = {
                parent_id: 0,
                sort_num: 0
            }
            this.showDialog = true;
        },
        onDelete(id) {
            this.$confirm(this.$t('category.delete_tips'), this.$t('common.delete_confirm'), {
                type: 'warning'
            }).then(() => {
                CategoryService.batchDelete([id]).then(() => {
                    this.fetchList();
                });
            });
        },
        onAddChild(id) {
            this.category = {
                parent_id: id,
                sort_num: 0
            }
            this.showDialog = true;
        },

        onIncrease(id) {
            CategoryService.increase(id).then(() => {
                this.fetchList();
            });
        },
        onDecrease(id) {
            CategoryService.decrease(id).then(() => {
                this.fetchList();
            });
        },
        onSascaderChange(arr) {
            if (arr.length > 0) this.category.parent_id = arr[arr.length - 1];
        },
        onSubmit() {
            let {category} = this;
            if (!category.name) {
                this.$message.error(this.$t('category.name_required'));
                return false;
            }
            category.taxonomy = this.taxonomy;
            if (category.id) {
                CategoryService.update(category.id, category).then(() => {
                    this.fetchList();
                    this.showDialog = false;
                    this.$message.success(this.$t('category.updated'));
                });
            } else {
                CategoryService.store(category).then(() => {
                    this.fetchList();
                    this.showDialog = false;
                    this.$message.success(this.$t('category.saved'));
                });
            }
        },
        onChooseImage(media) {
            this.category.image = media.src;
        },
    },
    mounted() {
        this.fetchList();
    }
}
</script>

<style scoped>

</style>