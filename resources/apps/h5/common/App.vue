<template>
    <div id="app">
        <router-view :key="$route.fullPath"/>
    </div>
</template>

<script>
    import {LOGIN} from "../vuex/types";

    export default {
        name: "App",
        mounted() {
            this.$get('/user/info').then(response => {
                this.$store.commit(LOGIN, response.data);
            });
        }
    }
</script>

<style scoped>

</style>
