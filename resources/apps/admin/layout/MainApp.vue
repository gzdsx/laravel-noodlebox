<template>
    <div class="admin-app" id="app">
        <top-bar/>
        <side-bar/>
        <router-view :key="$route.fullPath"/>
    </div>
</template>

<script>
import TopBar from "./TopBar";
import SideBar from "./SideBar";

const store = require('../store');
export default {
    name: "MainApp",
    components: {SideBar, TopBar},
}
</script>

<style scoped>

</style>
