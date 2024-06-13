<template>
    <product-meta-boxes :product="product" v-if="!loading"/>
</template>

<script>
import ProductMetaBoxes from "./ProductMetaBoxes.vue";
import HttpClient from "../HttpClient";

export default {
    name: "ProductMetaApp",
    components: {ProductMetaBoxes},
    data() {
        return {
            product: {},
            loading: true
        }
    },
    mounted() {
        HttpClient.get(`/products/${g_config.productId}`).then(response => {
            this.product = response.data;
        }).catch(reason => {

        }).finally(() => {
            this.loading = false;
        });
    }
}
</script>

<style scoped>

</style>