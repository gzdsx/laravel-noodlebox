<template>
    <div class="admin-sidebar">
        <div class="v-common-nav">
            <el-collapse>
                <el-collapse-item v-for="(nav,index) in navs" :key="index">
                    <div class="v-nav-item" slot="title">
                        <i class="v-nav-icon bi" :class="'bi-'+nav.icon"></i>
                        <span>{{ $t(nav.name) }}</span>
                    </div>
                    <div class="v-nav-link" v-for="(nav2,idx) in nav.children" :key="idx">
                        <router-link :to="nav2.path" v-if="nav2.path">{{ $t(nav2.name) }}</router-link>
                        <a :href="nav2.href" target="_blank" v-else>{{ nav2.name }}</a>
                    </div>
                </el-collapse-item>
            </el-collapse>
        </div>
    </div>
</template>

<script>
import menus from "../menus";

export default {
    name: "SideBar",
    data() {
        return {

        }
    },
    computed: {
        userInfo() {
            return this.$store.state.userInfo;
        },
        navs() {
            const navs = [];
            const capability = this.userInfo.capability || '';
            menus.map((menu) => {
                if (capability === 'administrator') {
                    navs.push(menu);
                } else {
                    if (menu.capabilities.includes(capability)) {
                        let navItem = {
                            name: menu.name,
                            icon: menu.icon,
                            children: []
                        };

                        menu.children.map((child) => {
                            if (child.capabilities.includes(capability)) {
                                navItem.children.push(child);
                            }
                        });

                        navs.push(navItem);
                    }
                }
            });

            return navs;
        }
    },
    mounted() {

    }
}
</script>

<style scoped>

</style>
