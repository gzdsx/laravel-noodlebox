<template>
    <main-layout>
        <div class="d-flex" slot="header">
            <h2 class="flex-grow-1">商品管理</h2>
            <div>
                <router-link to="/product/new">
                    <el-button type="primary" size="small">添加商品</el-button>
                </router-link>
            </div>
        </div>

        <div class="page-section">
            <div class="dsxui-form-inline">
                <div class="form-item">
                    <div class="form-item-label">产品ID</div>
                    <el-input size="medium" class="w200" clearable v-model="params.product_id"/>
                </div>
                <div class="form-item">
                    <div class="form-item-label">产品名称</div>
                    <el-input size="medium" class="w200" clearable v-model="params.title"/>
                </div>
                <div class="form-item">
                    <div class="form-item-label">目录分类</div>
                    <div class="form-item-input">
                        <el-cascader
                                :options="cascaderOptions"
                                :props="{checkStrictly:true}"
                                :clearable="true"
                                size="medium"
                                class="w200"
                                style="height: 36px;"
                                v-model="category_id"
                                @change="onCascaderChange"
                        />
                    </div>
                </div>
                <div class="form-item">
                    <el-button size="medium" type="primary" @click="onSearch">查询</el-button>
                </div>
            </div>
        </div>

        <div class="page-section">
            <div class="tablenav-top">
                <el-tabs @tab-click="onClickTab" value="all">
                    <el-tab-pane label="全部" name="all"/>
                    <el-tab-pane label="出售中" name="onsale"/>
                    <el-tab-pane label="已下架" name="delisted"/>
                    <el-tab-pane label="已售罄" name="soldout"/>
                    <el-tab-pane label="草稿" name="draft"/>
                </el-tabs>
            </div>
            <el-table :data="dataList" v-loading="loading" @selection-change="onSelectionChange">
                <el-table-column width="40" type="selection"/>
                <el-table-column label="图片" width="70">
                    <template slot-scope="scope">
                        <a :href="'/#'+scope.row.url" target="_blank">
                            <el-image :src="scope.row.image" fit="cover" class="img-60"/>
                        </a>
                    </template>
                </el-table-column>
                <el-table-column label="产品名称">
                    <template slot-scope="scope">
                        <div class="post-column-title">
                            <a :href="scope.row.url" target="_blank">{{ scope.row.title }}</a>
                        </div>
                        <small class="text-muted" v-if="scope.row.shop">{{ scope.row.shop.shop_name }}</small>
                        <div class="post-column-actions">
                            <router-link :to="'/product/edit/'+scope.row.id">编辑</router-link>
                            <span>|</span>
                            <a @click="deleteRecords([scope.row.id])">永久删除</a>
                            <span>|</span>
                            <a :href="scope.row.url" target="_blank">预览</a>
                        </div>
                    </template>
                </el-table-column>
                <el-table-column label="分类" width="200">
                    <template slot-scope="scope">
                        <div class="post-column-categories" v-if="scope.row.categories">
                            <a class="text-primary" v-for="(c,i) in scope.row.categories" :key="i"
                               @click="selectCategory(c.id)">{{ c.name }}</a>
                        </div>
                    </template>
                </el-table-column>
                <el-table-column prop="price" width="100" label="单价"/>
                <el-table-column prop="sold" width="80" label="销量"/>
                <el-table-column prop="status_des" width="80" label="状态"/>
                <el-table-column prop="created_at" width="170" label="上架时间" align="right"/>
            </el-table>
            <div class="tablenav tablenav-bottom">
                <el-button size="small" type="primary" :disabled="selectionIds.length === 0" @click="onBatchDelete">
                    批量删除
                </el-button>
                <el-button size="small" :disabled="selectionIds.length === 0"
                           @click="onBatchUpdate({state:1})">批量上架
                </el-button>
                <el-button size="small" :disabled="selectionIds.length === 0"
                           @click="onBatchUpdate({state:0})">批量下架
                </el-button>
                <div class="flex"></div>
                <el-pagination
                        background
                        layout="prev, pager, next,total"
                        :total="total"
                        :page-size="pageSize"
                        :current-page="page"
                        @current-change="onPageChange"
                />
            </div>
        </div>
    </main-layout>
</template>

<script>
import CategoryService from "../utils/CategoryService";
import ProductService from "../utils/ProductService";
import Pagination from "../mixins/Pagination";

const defaultParams = {
    product_id: '',
    title: '',
    category: '',
    status: '',
    sort: 'time-desc'
};
export default {
    name: "ProductList",
    mixins: [Pagination],
    data() {
        return {
            params: defaultParams,
            cascaderOptions: [],
            category_id: 0
        }
    },
    methods: {
        listApi() {
            return '/products';
        },
        listParams() {
            return this.params;
        },
        fetchCategories() {
            CategoryService.list({taxonomy: 'product'}).then(response => {
                this.cascaderOptions = CategoryService.generateCascaderOptions(response.result.items);
            });
        },
        deleteRecords(ids) {
            this.$confirm(this.$t('common.delete_tips'), this.$t('common.delete_confirm'), {
                type: 'warning'
            }).then(() => {
                ProductService.deleteProducts(ids).then(() => {
                    this.fetchList();
                });
            });
        },
        onBatchDelete() {
            let ids = this.selectionIds.map((d) => d.id);
            this.deleteRecords(ids);
        },
        onClickTab(tab) {
            if (tab.name === 'all') {
                this.params = defaultParams
            } else {
                this.params.status = tab.name;
            }
            this.onSearch();
        },
        onBatchUpdate(data) {
            let ids = this.selectionIds.map((d) => d.id);
            ProductService.batchUpdate(ids, data).then(() => {
                this.fetchList();
            });
        },
        onCascaderChange(v) {
            if (v.length > 0) {
                this.params.category = v[v.length - 1];
            } else {
                this.params.category = '';
            }
        },
        selectCategory(id) {
            this.category_id = id;
            this.params.category = id;
            this.onSearch();
        },
    },
    mounted() {
        this.fetchList();
        this.fetchCategories();
    },
}
</script>

<style scoped>

</style>
