<template>
    <div class="admin-main">
        <header class="page-header">
            <slot name="header"></slot>
        </header>
        <main class="page-body">
            <slot></slot>
        </main>
        <slot name="footer"></slot>
    </div>
</template>

<script>
export default {
    name: "MainLayout",
    props: {
        loading: {
            type: Boolean,
            default: true
        }
    },
    watch: {
        loading(val) {
        }
    }
}
</script>

<style scoped>

</style>
