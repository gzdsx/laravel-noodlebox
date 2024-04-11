<template>
    <div class="gzdsx-pos">
        <navigation/>
        <router-view :key="$route.fullPath"/>
        <pos-login v-if="!$store.state.isLoggedIn"/>
    </div>
</template>

<script>
import Navigation from "./Navigation.vue";
import PosLogin from "./PosLogin.vue";

export default {
    name: "Main",
    components: {PosLogin, Navigation},
    data() {
        return {}
    },
    computed: {},
    mounted() {

    },
    beforeMount() {

    }
}
</script>

<style scoped>

</style>