<template>
    <div class="admin-sidebar">
        <div class="v-common-nav">
            <el-collapse>
                <el-collapse-item v-for="(nav,index) in navs" :name="index" :key="index">
                    <div class="v-nav-item" slot="title">
                        <i class="v-nav-icon bi" :class="'bi-'+nav.icon"></i>
                        <span>{{ $t(nav.name) }}</span>
                    </div>
                    <div class="v-nav-link" v-for="(nav2,idx) in nav.children" :key="idx">
                        <a :href="nav2.path" target="_blank" v-if="nav2.isLink">{{ nav2.name }}</a>
                        <router-link :to="nav2.path" v-else>{{ $t(nav2.name) }}</router-link>
                    </div>
                </el-collapse-item>
            </el-collapse>
        </div>
    </div>
</template>

<script>
import navs from "../navs";

export default {
    name: "Sidebar",
    data() {
        return {
            navs
        }
    }
}
</script>

<style scoped>

</style>
