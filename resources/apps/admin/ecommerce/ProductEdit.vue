<template>
    <main-layout>
        <div class="d-flex" slot="header">
            <h2 class="header-left">编辑产品</h2>
            <div class="header-right">
                <a :href="product.url" target="_blank" v-if="product.id">
                    <el-button size="small">{{ $t('post.preview') }}</el-button>
                </a>
                <router-link to="/product/new">
                    <el-button size="small" type="primary">添加产品</el-button>
                </router-link>
            </div>
        </div>

        <section class="post-body">
            <div class="post-body-main">
                <el-form size="medium" label-width="100px">
                    <div class="post-card">
                        <div class="post-card-header">
                            <h2>产品信息</h2>
                        </div>
                        <div class="post-card-body">
                            <el-form-item label="商品图片">
                                <vuedraggable class="dsxui-uploader" v-model="images" draggable=".draggable">
                                    <div class="dsxui-uploader-item draggable"
                                         v-for="(img,idx) in images"
                                         :key="idx"
                                    >
                                        <el-image :src="img.thumb" fit="cover"/>
                                        <div class="bi bi-x del-icon" @click.stop="images.splice(idx,1)"/>
                                    </div>
                                    <div class="dsxui-uploader-button" @click.stop="onSelectedImages"
                                         v-if="images.length<maxImageCount">
                                        <i class="el-icon-plus dsxui-uploader-icon"></i>
                                    </div>
                                </vuedraggable>
                                <p>建议尺寸：800*800像素，拖拽图片可以调整顺序，最多上传5张。</p>
                            </el-form-item>
                            <el-form-item label="产品名称">
                                <el-input type="text" v-model="product.title"/>
                            </el-form-item>
                            <el-form-item :label="$t('common.url')">
                                <el-input size="medium" v-model="product.slug">
                                    <span slot="prepend">{{ siteUrl }}/product/</span>
                                </el-input>
                            </el-form-item>
                            <el-form-item label="关键词">
                                <el-input type="text" v-model="product.keywords"/>
                            </el-form-item>
                            <el-form-item label="简短描述">
                                <el-input type="textarea" rows="5" v-model="product.description"/>
                            </el-form-item>
                            <el-form-item label="徽章">
                                <div class="badges-wrapper">
                                    <div class="badge-item" v-for="(badge,idx) in meta_data.badges" :key="idx">
                                        <img :src="badge" alt="">
                                        <i class="el-icon-close delete" @click="meta_data.badges.splice(idx)"></i>
                                    </div>
                                    <div class="badge-item addnew" @click="showBadgePanel=true">
                                        <el-icon name="plus"/>
                                    </div>
                                </div>
                            </el-form-item>
                            <el-form-item label="新品">
                                <el-switch
                                    v-model="product.is_new"
                                    :active-value="1"
                                    :inactive-value="0"
                                />
                            </el-form-item>
                            <el-form-item label="热销商品">
                                <el-switch
                                    v-model="product.is_hot"
                                    :active-value="1"
                                    :inactive-value="0"
                                />
                            </el-form-item>
                            <el-form-item label="积分换购">
                                <el-switch
                                    v-model="product.allow_point_purchase"
                                    :active-value="1"
                                    :inactive-value="0"
                                />
                            </el-form-item>
                            <el-form-item label="积分价格">
                                <el-input type="number" class="w200" v-model="product.point_price" :min="0"
                                          :max="99999999"/>
                            </el-form-item>
                        </div>
                    </div>

                    <div class="post-card">
                        <div class="post-card-header">
                            <h2>型号价格与库存</h2>
                        </div>
                        <div class="post-card-body">
                            <el-form-item label="价格与库存" v-if="product.has_sku_attr">
                                <sku-panel
                                        @change="onSkuChange"
                                />
                            </el-form-item>
                            <div v-else>
                                <el-form-item label="一口价">
                                    <el-input type="text" class="w200" v-model="product.price" :min="0"
                                              :max="99999999"/>
                                </el-form-item>
                                <el-form-item label="正常价">
                                    <el-input type="text" class="w200" v-model="product.regular_price" :min="0"
                                              :max="99999999"/>
                                </el-form-item>
                                <el-form-item label="库存数量">
                                    <el-input type="number" class="w200" v-model="product.stock" :min="0"
                                              :max="9999999"/>
                                </el-form-item>
                            </div>
                        </div>
                    </div>

                    <div class="post-card">
                        <div class="post-card-header">
                            <h2>变量和价格</h2>
                        </div>
                        <div class="post-card-body">
                            <variation-panel :variation-list="product.variation_list"/>
                        </div>
                    </div>

                    <div class="post-card">
                        <div class="post-card-header">
                            <h2>附加选项(多选)</h2>
                        </div>
                        <div class="post-card-body">
                            <addition-options-panel :additional-options="product.additional_options"/>
                        </div>
                    </div>

                    <div class="post-card">
                        <div class="post-card-header">
                            <h2>宝贝详情</h2>
                        </div>
                        <div class="post-card-body">
                            <wang-editor v-model="content.content" ref="editor"/>
                        </div>
                    </div>
                </el-form>
            </div>
            <div class="post-body-box">
                <div class="post-card">
                    <div class="post-card-header">
                        <h2>{{ $t('post.category') }}</h2>
                    </div>
                    <div class="post-card-body">
                        <div class="category-box">
                            <el-checkbox-group v-model="selectedCategories">
                                <category-checkbox-list :categories="categories"/>
                            </el-checkbox-group>
                        </div>
                    </div>
                </div>

                <div class="post-card">
                    <div class="post-card-header">
                        <h2>{{ $t('post.featured_image') }}</h2>
                    </div>
                    <div class="post-card-body">
                        <div class="feature-image-box" @click="selectFeatureImage">
                            <img :src="product.image" v-if="product.image" alt="">
                        </div>
                    </div>
                </div>

                <div class="post-card">
                    <div class="post-card-header">
                        <h2>其他属性</h2>
                    </div>
                    <div class="post-card-body">
                        <div class="form-label">关联门店</div>
                        <el-select size="medium" class="w-100" v-model="product.shop_id" placeholder="请选择">
                            <el-option
                                    v-for="(shop,index) in shopList"
                                    :key="index"
                                    :label="shop.name"
                                    :value="shop.id"
                            />
                        </el-select>
                        <div class="form-label">产品销量</div>
                        <el-input type="text" size="medium" v-model="product.sold" :min="0" :max="99999999"/>
                        <div class="form-label">产品积分</div>
                        <el-input type="text" size="medium" v-model="product.points" :min="0" :max="99999999"/>
                        <div class="form-label">显示顺序</div>
                        <el-input type="text" size="medium" v-model="product.sort_num" :min="0" :max="99999999"/>
                        <div class="form-label">辣度</div>
                        <el-select v-model="meta_data.spicy" class="w-100" size="medium" placeholder="请选择" clearable>
                            <el-option
                                    v-for="(item,index) in [
                                        {label:'不辣',value:''},
                                        {label:'微辣',value:'slightly'},
                                        {label:'中辣',value:'medium'},
                                        {label:'超辣',value:'super'},
                                    ]"
                                    :key="index"
                                    :label="item.label"
                                    :value="item.value"
                            />
                        </el-select>
                        <div class="form-label">图标</div>
                        <el-select v-model="product.icon" class="w-100" size="medium" placeholder="请选择" clearable>
                            <el-option
                                    v-for="(item,index) in [
                                        {label:'New',value:'new'},
                                        {label:'Hot',value:'hot'},
                                    ]"
                                    :key="index"
                                    :label="item.label"
                                    :value="item.value"
                            />
                        </el-select>
                    </div>
                </div>
            </div>
        </section>

        <fixed-bottom>
            <el-button @click="onSubmit('draft')">放入仓库</el-button>
            <el-button type="primary" @click="onSubmit('onsale')">上架出售</el-button>
        </fixed-bottom>
        <media-dialog v-model="showMediaDialog" :multiple="multipleMedia" :max-count="maxImageCount"
                      @confirm="selectedMedia"/>
        <badge-panel v-model="showBadgePanel" type="product" @confirm="onChooseBadges"/>
    </main-layout>
</template>

<script>
import SkuPanel from "./SkuPanel";
import ProductService from "../utils/ProductService";
import CategoryService from "../utils/CategoryService";
import ShopService from "../utils/ShopService";
import ApiService from "../utils/ApiService";
import CategoryCheckboxList from "../components/CategoryCheckboxList.vue";
import VariationPanel from "./VariationPanel.vue";
import variationList from "./VariationList.vue";
import AdditionOptionsPanel from "./AdditionOptionsPanel.vue";
import BadgePanel from "../components/BadgePanel.vue";

export default {
    name: "ProductEdit",
    computed: {
        variationList() {
            return variationList
        }
    },
    components: {
        BadgePanel,
        AdditionOptionsPanel,
        VariationPanel,
        CategoryCheckboxList,
        SkuPanel,
    },
    data() {
        let self = this;
        return {
            product: {
                template_id: '',
                has_sku_attr: 0,
                skus: [],
                variation_list: [],
                additional_options: [],
                stock: 1000,
                sold: 100,
                price: 0,
                regular_price: 0
            },
            skus: [],
            images: [],
            content: {},
            meta_data: {
                spicy: '',
                badges: []
            },
            templateList: [],
            shopList: [],
            categories: [],
            selectedCategories: [],
            showMediaDialog: false,
            maxImageCount: 5,
            multipleMedia: false,
            selectedMedia: function () {

            },
            siteUrl: window.siteUrl || window.location.origin,
            showBadgePanel: false
        }
    },
    methods: {
        fetchData() {
            let {id} = this.$route.params;
            if (!id) return;
            ProductService.getProduct(id || 0).then(response => {
                const product = response.data;
                const {images, skus, content, categories, meta_data} = product;

                this.product = product;
                if (content) this.content = content;
                if (meta_data) {
                    this.meta_data = {
                        ...this.meta_data,
                        ...meta_data
                    };
                }
                if (Array.isArray(skus)) this.skus = skus;
                if (Array.isArray(images)) this.images = images;
                if (Array.isArray(categories)) this.selectedCategories = categories.map(c => c.id);
            }).finally(() => {
                //this.loading = false;
            });
        },
        fetchCategories() {
            CategoryService.list({taxonomy: 'product'}).then(response => {
                this.categories = response.data.items;
                this.cascaderOptions = CategoryService.generateCascaderOptions(response.data.items);
            });
        },
        fetchTemplates() {
            ApiService.get('/freight-templates').then(response => {
                this.templateList = response.data.items;
            });
        },
        fetchShopList() {
            ShopService.listShops().then(response => {
                this.shopList = response.data.items;
                if (!this.product.shop_id) {
                    this.product.shop_id = this.shopList[0].id;
                }
            });
        },
        onSelectedImages() {
            this.multipleMedia = true;
            this.selectedMedia = images => {
                for (let img of images) {
                    if (this.images.length < this.maxImageCount) {
                        this.images.push({
                            id: 0,
                            thumb: img.thumb,
                            image: img.src
                        });
                    }
                }
            }
            this.showMediaDialog = true;
        },
        selectFeatureImage() {
            this.multipleMedia = false;
            this.selectedMedia = m => {
                this.product.image = m.src;
            }
            this.showMediaDialog = true;
        },
        onSkuChange(data) {
            this.skus = data.skus;
            this.product.skus = data.skus;
            this.product.attr_list = data.attrs;
        },
        onSubmit(type) {
            //console.log(this.product.variation_list);
            let {product, images, content, skus, meta_data} = this;
            let {title, price, stock} = product;

            if (images.length === 0) {
                this.$message.error('请至少上传一张图片');
                return false;
            }

            if (!title) {
                this.$message.error('请填写商品名称');
                return false;
            }

            if (skus.length > 0) {
                let prices = [];
                let stocks = [];
                for (let i = 0; i < skus.length; i++) {
                    if (skus[i].price === '' || skus[i].price == null) {
                        this.$message.error('产品价格不能为空');
                        return false;
                    }

                    if (skus[i].price <= 0) {
                        this.$message.error('产品价格小于等于0');
                        return false;
                    }

                    if (skus[i].stock === '' || skus[i].stock == null) {
                        this.$message.error('产品库存不能为空');
                        return false;
                    }

                    if (skus[i].stock < 0) {
                        this.$message.error('产品库存不能小于0');
                        return false;
                    }
                    prices.push(parseFloat(skus[i].price));
                    stocks.push(parseInt(skus[i].stock));
                }

                product.price = _.min(prices);
                product.stock = _.sum(stocks);
            } else {
                if (!price) {
                    this.$message.error('请填写产品价格');
                    return false;
                }

                if (stock === '' || stock == null) {
                    this.$message.error('产品库存不能为空');
                    return false;
                }
            }

            product.status = type;
            product.skus = skus;
            product.images = images;
            product.content = content;
            product.categories = this.selectedCategories;
            product.meta_data = meta_data;
            if (product.id) {
                ProductService.updateProduct(product.id, product).then(() => {
                    this.$message.success('产品已更新');
                    this.$router.history.go(0);
                }).catch(reason => {
                    this.$message.error(reason.message);
                }).finally(() => {
                    this.disabled = false;
                });
            } else {
                ProductService.storeProduct(product).then(res => {
                    this.$message.success('产品已保存');
                    this.$router.replace('/product/edit/' + res.data.id);
                }).catch(reason => {
                    this.$message.error(reason.message);
                }).finally(() => {
                    this.disabled = false;
                });
            }
        },
        onChooseBadges(badges) {
            const icons = badges.map(b => b.icon);
            this.meta_data.badges = this.meta_data.badges.concat(icons);
        },
        getArray(arr) {
            if (Array.isArray(arr)) {
                return arr;
            } else {
                return [];
            }
        },
    },
    mounted() {
        this.fetchData();
        this.fetchCategories();
        //this.fetchTemplates();
        this.fetchShopList();
    },
}
</script>

<style scoped>

</style>
