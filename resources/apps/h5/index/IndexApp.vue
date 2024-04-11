<template>
    <loading-view v-if="loading"/>
    <div class="home" v-else>
        <van-swipe class="swipe" :autoplay="3000" indicator-color="white">
            <van-swipe-item v-for="(item,index) in imageList" :key="index">
                <img :src="item.image" class="swipe-image" alt=""/>
            </van-swipe-item>
        </van-swipe>
        <div class="nav-list">
            <a v-for="(menu,index) in menuList" :key="index" :href="menu.url" class="nav-item">
                <div class="nav-icon">
                    <img :src="menu.image"/>
                </div>
                <div class="nav-title">{{ menu.name }}</div>
            </a>
        </div>
        <product-column-view :product-list="productList"/>
        <tab-bar :active-index="0"/>
    </div>
</template>

<script>
import TabBar from '../common/TabBar';
import ProductColumnView from "../ecom/components/ProductColumnView";

export default {
    name: "IndexApp",
    components: {
        ProductColumnView,
        TabBar,
    },
    data() {
        return {
            imageList: [],
            menuList: [],
            productList: [],
            loading: true
        }
    },
    methods: {
        async fetchData() {
            let response = await this.$get('/blocks/1');
            this.imageList = response.data.items;

            response = await this.$get('/categories?taxonomy=product');
            this.menuList = response.data.items;

            response = await this.$get('/products?limit=10');
            this.productList = response.data.items;

            this.loading = false;
        }
    },
    mounted() {
        this.fetchData();
    },
}
</script>

<style lang="scss">

</style>
