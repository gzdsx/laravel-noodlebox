<template>
    <div class="noodle-container">
        <slot/>
        <div class="noodle-mask" v-if="loading">
            <div class="spinner-border text-light" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "NoodleContainer",
    props: {
        loading: {
            type: Boolean,
            default: false
        }
    }
}
</script>

<style scoped>

</style>