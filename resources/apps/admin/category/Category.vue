<template>
    <category-manage :taxonomy="taxonomy"/>
</template>

<script>
import CategoryManage from "./CategoryManage";

export default {
    name: "Category",
    components: {CategoryManage},
    data() {
        return {
            taxonomy: 'post'
        }
    },
    created() {
        const {taxonomy} = this.$route.params;
        if (taxonomy) {
            this.taxonomy = taxonomy;
        }
    }
}
</script>

<style lang="scss" scoped>

</style>
