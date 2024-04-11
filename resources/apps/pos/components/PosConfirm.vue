<template>
    <div class="pos-modal-wrap" v-if="visible">
        <div class="pos-modal-content">
            <slot/>
        </div>
    </div>
</template>

<script>
export default {
    name: "PosConfirm",
    props: {
        visible: {
            type: Boolean,
            default: false
        }
    }
}
</script>

<style scoped>

</style>