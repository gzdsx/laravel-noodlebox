<template>
    <product-meta-boxes :product="product"/>
</template>

<script>
import ProductMetaBoxes from "./ProductMetaBoxes.vue";

export default {
    name: "ProductMetaApp",
    components: {ProductMetaBoxes},
    data() {
        return {
            product: window.product || {}
        }
    },
}
</script>

<style scoped>

</style>