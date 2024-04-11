<template>
    <div class="pos-tab-scroll">
        <div class="product-list" v-if="products.length">
            <div class="product-item" v-for="(product,index) in products" :key="index"
                 @click="select(product)">
                <div class="product-image" v-if="product.images.length > 0">
                    <img :src="$imageSrc(product.images[0].src)" alt="">
                </div>
                <div class="product-heading">
                    <div class="title">{{ product.name }}</div>
                    <div class="price">€{{ product.price }}</div>
                </div>
            </div>
        </div>
        <div class="empty-box" v-else></div>
    </div>
</template>

<script>
const defaultParams = {
    per_page: 18,
    status: 'publish'
}
export default {
    name: "ProductList",
    props: {
        params: {
            type: Object,
            default() {
                return {};
            }
        }
    },
    data() {
        return {
            page: 1,
            products: [],
            loading: true,
            loadingMore: false,
            hasMore: false
        }
    },
    methods: {
        fetchList() {
            const {page} = this;
            const params = Object.assign({}, defaultParams, this.params);
            params.page = page;
            this.$http.get('products', {params}).then(response => {
                if (this.loadingMore) {
                    this.products = this.products.concat(response);
                } else {
                    this.products = response;
                }
                this.hasMore = response.length === 18;
            }).catch(reason => {
                console.log(reason.message);
            }).finally(() => {
                this.loading = false;
                this.loadingMore = false;
            });
        },
        loadMore() {
            if (this.loading || this.loadingMore || !this.hasMore) {
                return false;
            }
            this.page++;
            this.loadingMore = true;
            this.fetchList();
        },
        select(p) {
            this.$emit('select', p);
        }
    },
    mounted() {
        this.fetchList();
        this.$el.addEventListener('scroll', event => {
            const scrollTop = this.$el.scrollTop;
            const scrollHeight = this.$el.scrollHeight;
            const clientHeight = this.$el.clientHeight;

            // console.log(this.$el.scrollTop);
            // console.log('scrollHeight:', this.$el.scrollHeight);

            if (scrollHeight - scrollTop < clientHeight + 10) {
                this.loadMore();
            }
        });
    }
}
</script>

<style scoped>

</style>