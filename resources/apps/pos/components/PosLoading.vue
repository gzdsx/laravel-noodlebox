<template>
    <div class="pos-modal-wrap" v-if="visible">
        <i class="pos-loading"></i>
    </div>
</template>

<script>
export default {
    name: "PosLoading",
    props:{
        visible: {
            type: Boolean,
            default: false
        },
    },
    watch: {
        visible(val) {
            if (val) {
                document.body.appendChild(this.$el);
            }
        }
    },
    created() {
        if (this.visible) {
            document.body.appendChild(this.$el);
        }
    },
    destroyed() {
        if (this.$el && this.$el.parentNode) {
            this.$el.parentNode.removeChild(this.$el);
        }
    },
}
</script>

<style scoped>

</style>