<template>
    <main-layout>
        <div class="d-flex" slot="header">
            <h2 class="flex-grow-1">{{$t('product.manage')}}</h2>
            <div>
                <router-link to="/product/new">
                    <el-button type="primary" size="small">{{$t('product.add')}}</el-button>
                </router-link>
            </div>
        </div>

        <div class="page-section">
            <div class="dsxui-form-inline">
                <div class="form-item">
                    <div class="form-item-label">{{$t('product.id')}}</div>
                    <el-input size="medium" class="w200" clearable v-model="params.product_id"/>
                </div>
                <div class="form-item">
                    <div class="form-item-label">{{$t('product.name')}}</div>
                    <el-input size="medium" class="w200" clearable v-model="params.title"/>
                </div>
                <div class="form-item">
                    <div class="form-item-label">{{$t('product.category')}}</div>
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
                    <el-button size="medium" type="primary" @click="onSearch">{{$t('common.search')}}</el-button>
                </div>
            </div>
        </div>

        <div class="page-section">
            <div class="tablenav-top">
                <el-tabs @tab-click="onClickTab" value="all">
                    <el-tab-pane :label="$t('common.all')" name="all"/>
                    <el-tab-pane :label="$t('product.statuses.onsale')" name="onsale"/>
                    <el-tab-pane :label="$t('product.statuses.delisted')" name="delisted"/>
                    <el-tab-pane :label="$t('product.statuses.soldout')" name="soldout"/>
                    <el-tab-pane :label="$t('product.statuses.draft')" name="draft"/>
                </el-tabs>
            </div>
            <el-table :data="dataList" v-loading="loading" @selection-change="onSelectionChange">
                <el-table-column width="40" type="selection"/>
                <el-table-column :label="$t('product.image')" width="70">
                    <template slot-scope="scope">
                        <a :href="'/#'+scope.row.url" target="_blank">
                            <el-image :src="scope.row.image" fit="cover" class="img-60"/>
                        </a>
                    </template>
                </el-table-column>
                <el-table-column :label="$t('product.name')">
                    <template slot-scope="scope">
                        <div class="post-column-title">
                            <a :href="scope.row.url" target="_blank">
                                {{ scope.row.title }}
                                <span class="tag-top" v-if="scope.row.sticky">TOP</span>
                            </a>
                        </div>
                        <small class="text-muted" v-if="scope.row.shop">{{ scope.row.shop.shop_name }}</small>
                        <div class="post-column-actions">
                            <router-link :to="'/product/edit/'+scope.row.id">{{ $t('common.edit') }}</router-link>
                            <span>|</span>
                            <a @click="deleteRecords([scope.row.id])">{{ $t('common.permanently_delete')}}</a>
                            <span>|</span>
                            <a :href="scope.row.url" target="_blank">{{ $t('common.preview') }}</a>
                        </div>
                    </template>
                </el-table-column>
                <el-table-column :label="$t('product.category')" width="200">
                    <template slot-scope="scope">
                        <div class="post-column-categories" v-if="scope.row.categories">
                            <a class="text-primary" v-for="(c,i) in scope.row.categories" :key="i"
                               @click="selectCategory(c.id)">{{ c.name }}</a>
                        </div>
                    </template>
                </el-table-column>
                <el-table-column prop="price" width="100" :label="$t('product.price')"/>
                <el-table-column prop="sold" width="80" :label="$t('product.sales')"/>
                <el-table-column prop="status_des" width="80" :label="$t('product.status')"/>
                <el-table-column prop="created_at" width="170" :label="$t('product.pubtime')" align="right"/>
            </el-table>
            <div class="tablenav tablenav-bottom">
                <div class="table-actions">
                    <el-select size="small" v-model="batchAction">
                        <el-option :label="$t('product.actions.delete')" value="delete"/>
                        <el-option :label="$t('product.actions.listing')" value="listing"/>
                        <el-option :label="$t('product.actions.delist')" value="delist"/>
                        <el-option :label="$t('product.actions.top')" value="top"/>
                        <el-option :label="$t('product.actions.untop')" value="untop"/>
                        <el-option :label="$t('product.actions.up')" value="up"/>
                        <el-option :label="$t('product.actions.down')" value="down"/>
                    </el-select>
                    <el-button size="small" type="primary" :disabled="selectionIds.length === 0"
                               @click="onBatchOperation">
                        {{$t('common.apply')}}
                    </el-button>
                    <el-button size="small" @click="onExport">
                        Export
                    </el-button>
                </div>
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
            category_id: 0,
            batchAction: ''
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
                this.cascaderOptions = CategoryService.generateCascaderOptions(response.data.items);
            });
        },
        deleteRecords(ids) {
            this.$confirm(this.$t('common.delete_tips'), this.$t('common.delete_confirm'), {
                type: 'warning'
            }).then(() => {
                this.loading = true;
                ProductService.deleteProducts(ids).then(() => {
                    this.fetchList();
                });
            });
        },
        onClickTab(tab) {
            if (tab.name === 'all') {
                this.params.status = '';
            } else {
                this.params.status = tab.name;
            }
            this.onSearch();
        },
        onBatchUpdate(data) {
            let ids = this.selectionIds.map((d) => d.id);
            this.loading = true;
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
        onBatchOperation() {
            let ids = this.selectionIds.map((d) => d.id);
            let {batchAction} = this;
            if (batchAction === 'delete') {
                this.deleteRecords(ids);
            } else {
                this.loading = true;
                ProductService.batchAdjust(ids, batchAction).then(() => {
                    this.fetchList();
                }).finally(() => {
                    //this.loading = false;
                });
            }
        },
        onExport(){
            window.open('/orders/export')
        }
    },
    mounted() {
        this.fetchList();
        this.fetchCategories();
    },
}
</script>

<style scoped>

</style>
