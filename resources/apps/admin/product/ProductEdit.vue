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
                                    <span slot="prepend">{{siteUrl}}/</span>
                                </el-input>
                            </el-form-item>
                            <el-form-item label="关键词">
                                <el-input type="text" v-model="product.keywords"/>
                            </el-form-item>
                            <el-form-item label="简短描述">
                                <el-input type="textarea" rows="5" v-model="product.description"/>
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
                        <div class="form-label">运费模板</div>
                        <el-select size="medium" class="w-100" v-model="product.template_id" placeholder="请选择">
                            <el-option
                                    v-for="(tpl,index) in templateList"
                                    :label="tpl.template_name"
                                    :value="tpl.template_id"
                                    :key="index"
                            />
                        </el-select>
                        <div class="form-label">产品销量</div>
                        <el-input type="text" size="medium" v-model="product.sold" :min="0" :max="99999999"/>
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

export default {
    name: "ProductEdit",
    computed: {
        variationList() {
            return variationList
        }
    },
    components: {
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
                stock: 1000,
                sold: 100,
                price: 0,
                regular_price: 0
            },
            skus: [],
            images: [],
            content: {},
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
        }
    },
    methods: {
        fetchData() {
            let {id} = this.$route.params;
            if (!id) return;
            ProductService.getProduct(id || 0).then(response => {
                const product = response.result;
                const {images, skus, content, categories, metas} = product;

                this.product = product;
                if (content) this.content = content;
                if (Array.isArray(skus)) this.skus = skus;
                if (Array.isArray(images)) this.images = images;
                if (Array.isArray(categories)) this.selectedCategories = categories.map(c => c.id);
            });
        },
        fetchCategories() {
            CategoryService.list({taxonomy: 'product'}).then(response => {
                this.categories = response.result.items;
                this.cascaderOptions = CategoryService.generateCascaderOptions(response.result.items);
            });
        },
        fetchTemplates() {
            ApiService.get('/freight-templates').then(response => {
                this.templateList = response.result.items;
            });
        },
        fetchShopList() {
            ShopService.listShops().then(response => {
                this.shopList = response.result.items;
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
            console.log(this.product.variation_list);
            let {product, images, content, skus} = this;
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
                    this.$router.replace('/product/edit/' + res.result.id);
                }).catch(reason => {
                    this.$message.error(reason.message);
                }).finally(() => {
                    this.disabled = false;
                });
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
