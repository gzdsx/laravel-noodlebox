<template>
    <div class="pos-product-list__category" v-if="category">
        <div class="pos-product-list__go-back-wrapper">
            <div class="pos-product-list__btn pos-product-list__go-back" @click="category=0">
                <i class="yith-pos-icon-arrow-left"></i>
            </div>

            <div class="pos-product-list__btn" @click="prevPage">
                <i class="yith-pos-icon-arrow-left prev"></i>
            </div>

            <div class="pos-product-list__btn" @click="nextPage">
                <i class="yith-pos-icon-arrow-left next"></i>
            </div>

            <div
                    class="pos-product-list__color"
                    :style="{'background-color': theColor}"
                    @click="showPicker=!showPicker"
            >
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                     class="bi bi-eyedropper" viewBox="0 0 16 16">
                    <path d="M13.354.646a1.207 1.207 0 0 0-1.708 0L8.5 3.793l-.646-.647a.5.5 0 1 0-.708.708L8.293 5l-7.147 7.146A.5.5 0 0 0 1 12.5v1.793l-.854.853a.5.5 0 1 0 .708.707L1.707 15H3.5a.5.5 0 0 0 .354-.146L11 7.707l1.146 1.147a.5.5 0 0 0 .708-.708l-.647-.646 3.147-3.146a1.207 1.207 0 0 0 0-1.708zM2 12.707l7-7L10.293 7l-7 7H2z"/>
                </svg>
                <div class="picker" v-show="showPicker">
                    <pos-color-picker v-model="theColor" @select="onSelectColor"/>
                </div>
            </div>
        </div>
        <div class="pos-product-list__scroll" ref="scroll" v-click-outside="clickOutSide">
            <div class="pos-product-list__loading" v-if="loading">
                <i class="pos-loading"></i>
            </div>
            <div class="pos-product-list__list" v-else>
                <div
                        class="pos-product-list__item"
                        v-for="(product,index) in products"
                        :key="index"
                        :style="{'background-color': product.color}"
                        @click.stop="selectProduct(product)"
                >
                    <div class="title">{{ product.title }}</div>
                    <div class="price">€{{ product.price }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-scroll" v-else>
        <div class="pos-categories">
            <div class="pos-category" v-for="(c,index) in categories" :key="index" @click="selectCat(c)">
                <div class="pos-category__image">
                    <img :src="c.image" alt="">
                </div>
                <div class="pos-category__heading" v-html="c.name"></div>
            </div>
        </div>
    </div>
</template>

<script>
import PosColorPicker from "./PosColorPicker.vue";

const defaultColor = '#6c757d';
export default {
    name: "ProductCategories",
    components: {
        PosColorPicker
    },
    data() {
        return {
            categories: [],
            products: [],
            category: 0,
            page: 1,
            loading: true,
            loadingMore: false,
            hasMore: false,
            showPicker: false,
            theColor: defaultColor,
            selectProduct: (product) => {
                this.$beep.play();
                this.$emit('select', p);
            }
        }
    },
    methods: {
        fetchList() {
            let {category, page} = this;
            this.loading = true;
            this.$http.get('/products', {
                params: {
                    category,
                    page,
                    status: 'onsale'
                }
            }).then(response => {
                let {items, total} = response.data;
                items.forEach(product => {
                    if (product.meta_data._pos_color) {
                        product.color = product.meta_data._pos_color;
                    } else {
                        product.color = defaultColor;
                    }
                });
                if (this.loadingMore) {
                    this.products = this.products.concat(items);
                } else {
                    this.products = items;
                }

                this.hasMore = items.length === 100;
                this.$forceUpdate();
            }).catch(reason => {
                console.log(reason.message);
            }).finally(() => {
                this.loading = false;
                this.loadingMore = false;
            })
        },
        fetchCategories() {
            this.$http.get('/categories', {
                params: {
                    taxonomy: 'product',
                    excludes: '15,221',
                    offset: 0
                }
            }).then(response => {
                this.categories = response.data.items;
            }).catch(reason => {
                console.log(reason);
            }).finally(() => {
                this.loading = false;
            });
        },
        select(p) {
            this.$emit('select', p);
        },
        selectCat(c) {
            this.category = c.id;
            this.page = 1;
            this.products = [];
            this.fetchList();
        },
        loadMore() {
            if (this.loading || this.loadingMore || !this.hasMore) {
                return false;
            }
            this.page++;
            this.loadingMore = true;
            this.fetchList();
        },
        scroll() {
            let dom = this.$refs.products;
            dom.addEventListener('scroll', event => {
                const scrollTop = dom.scrollTop;
                const scrollHeight = dom.scrollHeight;
                const clientHeight = dom.clientHeight;

                if (scrollHeight - scrollTop < clientHeight + 10) {
                    this.loadMore();
                }
            });
        },
        nextPage() {
            // if (this.hasMore) {
            //     this.page++;
            //     this.fetchList();
            // }

            this.$refs.scroll.scrollTop += 200;
        },
        prevPage() {
            this.$refs.scroll.scrollTop -= 200;
            // if (this.page > 1) {
            //     this.page--;
            //     this.fetchList();
            // }
        },
        onSelectColor(color) {
            this.$beep.play();
            this.showPicker = false;
            this.selectProduct = product => {
                this.$beep.play();
                this.$http.post('/products/' + product.id + '/color', {color});
                product.color = color;
            }
        },
        clickOutSide() {
            this.theColor = defaultColor;
            this.selectProduct = p => {
                this.$beep.play();
                this.$emit('select', p);
            }
        },
    },
    mounted() {
        this.fetchCategories();
    }
}
</script>

<style scoped>

</style>