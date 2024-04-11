<template>
    <div class="noodle-loading-wrapper">
        <div class="spinner-border text-light" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
</template>

<script>
export default {
    name: "NoodleLoading",
    mounted() {
        document.body.appendChild(this.$el);
    },
    destroyed() {
        if (this.$el && this.$el.parentNode) {
            this.$el.parentNode.removeChild(this.$el);
        }
    }
}
</script>

<style scoped>

</style>