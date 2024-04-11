<template>
    <main-layout>
        <div class="d-flex" slot="header">
            <h2 class="flex-grow-1">{{ $t('post.manage') }}</h2>
            <div>
                <router-link to="/post/edit">
                    <el-button type="primary" size="small">{{ $t('post.addnew') }}</el-button>
                </router-link>
            </div>
        </div>

        <section class="page-section">
            <div class="form-inline">
                <div class="form-item">
                    <div class="form-item-label">{{ $t('post.title') }}</div>
                    <div class="form-item-input">
                        <el-input size="medium" class="w200" :clearable="true" v-model="params.title"/>
                    </div>
                </div>
                <div class="form-item">
                    <div class="form-item-label">{{ $t('post.category') }}</div>
                    <div class="form-item-input">
                        <el-cascader
                                v-model="cascaderValue"
                                :options="cascaderOptions"
                                :props="{checkStrictly:true}"
                                size="medium"
                                class="w200"
                                :clearable="true"
                                style="height: 36px;"
                                @change="onSascaderChange"
                        />
                    </div>
                </div>
                <div class="form-item">
                    <div class="form-item-label">{{ $t('post.status') }}</div>
                    <div class="form-item-input">
                        <el-select size="medium" v-model="params.status">
                            <el-option value="" :label="$t('post.all')"/>
                            <el-option value="publish" :label="$t('post.publish')"/>
                            <el-option value="draft" :label="$t('post.draft')"/>
                        </el-select>
                    </div>
                </div>
                <div class="form-item">
                    <el-button size="medium" type="primary" @click="onSearch">{{ $t('post.search') }}</el-button>
                </div>
            </div>
        </section>

        <section class="page-section">
            <el-table :data="dataList" v-loading="loading" @selection-change="onSelectionChange">
                <el-table-column width="45" type="selection"/>
                <el-table-column :label="$t('post.image')" width="70">
                    <template slot-scope="scope">
                        <div @click="onChangeImage(scope.row)">
                            <el-image :src="scope.row.image" class="post-thumbnail" v-if="scope.row.image"/>
                            <div class="post-thumbnail" v-else></div>
                        </div>
                    </template>
                </el-table-column>
                <el-table-column prop="title" :label="$t('post.title')">
                    <template slot-scope="scope">
                        <div class="post-column-title">
                            <a :href="scope.row.url" target="_blank">{{ scope.row.title }}</a>
                        </div>
                        <div class="post-column-actions">
                            <router-link :to="'/post/edit/'+scope.row.id">{{ $t('common.edit') }}</router-link>
                            <span>|</span>
                            <a @click="onDelete(scope.row.id)">{{ $t('common.delete_forever') }}</a>
                            <span>|</span>
                            <a :href="scope.row.url" target="_blank">{{ $t('common.preview') }}</a>
                        </div>
                    </template>
                </el-table-column>
                <el-table-column prop="user.nickname" width="120" :label="$t('post.author')"/>
                <el-table-column prop="category.cate_name" width="160" :label="$t('post.category')">
                    <template slot-scope="scope">
                        <div class="post-column-categories">
                            <a v-for="(cate,idx) in scope.row.categories">{{ cate.name }}</a>
                        </div>
                    </template>
                </el-table-column>
                <el-table-column prop="views" width="80" :label="$t('common.views')"/>
                <el-table-column prop="status_des" width="100" :label="$t('post.status')"/>
                <el-table-column prop="created_at" width="170" :label="$t('common.published_at')" align="right"/>
            </el-table>
            <div class="tablenav tablenav-bottom">
                <div class="table-actions">
                    <el-button size="small" type="primary" :disabled="selectionIds.length===0" @click="onBatchDelete">
                        {{ $t('common.batch_delete') }}
                    </el-button>
                    <el-button size="small" :disabled="selectionIds.length===0" @click="onBatchUpdate('publish')">
                        {{ $t('post.publish_now') }}
                    </el-button>
                    <el-button size="small" :disabled="selectionIds.length===0" @click="onBatchUpdate('draft')">
                        {{ $t('post.save_draft') }}
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
        </section>
    </main-layout>
</template>

<script>
import CategoryService from "../utils/CategoryService";
import PostService from "../utils/PostService";
import Pagination from "../mixins/Pagination";

export default {
    name: "PostList",
    mixins: [Pagination],
    data() {
        return {
            type: 'post',
            params: {
                q: '',
                cate: '',
                status: '',
                sort: 'id-desc'
            },
            cascaderOptions: [],
            cascaderValue: [],
            post: {}
        }
    },
    methods: {
        listApi() {
            return '/posts';
        },
        listParams() {
            const {type, params} = this;
            return {
                ...params,
                type
            }
        },
        fetchCategories() {
            CategoryService.list({taxonomy: this.type}).then(response => {
                this.cascaderOptions = CategoryService.generateCascaderOptions(response.data.items);
            });
        },
        deleteRecords(ids) {
            this.$confirm(this.$t('common.delete_tips'), this.$t('common.delete_confirm'), {
                type: 'warning'
            }).then(() => {
                PostService.batchDelete(ids).then(() => {
                    this.fetchList();
                });
            });
        },
        onDelete(id) {
            this.deleteRecords([id]);
        },
        onBatchDelete() {
            let ids = this.selectionIds.map((d) => d.id);
            this.deleteRecords(ids);
        },
        onChangeImage(p) {
            this.post = p;
        },
        onBatchUpdate(status) {
            let ids = this.selectionIds.map((d) => d.id);
            PostService.batchUpdate(ids, {status}).then(() => {
                this.fetchList();
            });
        },
        onSascaderChange(arr) {
            if (arr.length > 0) {
                this.params.cate = arr[arr.length - 1];
            } else {
                this.params.cate = '';
            }
        },
    },
    created() {
        const {type} = this.$route.query;
        if (type) this.type = type;
    },
    mounted() {
        this.fetchList();
        this.fetchCategories();
    },
}
</script>

<style scoped>

</style>
