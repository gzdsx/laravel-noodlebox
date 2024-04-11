<template>
    <div v-if="loading"></div>
    <div class="admin-app" id="app" v-else>
        <top-bar v-if="$route.name !== 'login'"/>
        <sidebar v-if="$route.name !== 'login'"/>
        <router-view :key="$route.fullPath"/>
    </div>
</template>

<script>
import ApiService from "../utils/ApiService";
import TopBar from "./TopBar.vue";
import Sidebar from "./Sidebar.vue";

export default {
    name: "MainApp",
    components: {Sidebar, TopBar},
    data() {
        return {
            loading: true
        }
    },
    methods: {
        loadDefaultLang() {
            ApiService.get('/locale/messages').then(response => {
                const {locale, messages} = response.data;
                this.$i18n.setLocaleMessage('locale', messages);
                this.$lang = locale;
            }).catch(reason => {
                console.log(reason.message);
            }).finally(() => {
                this.loading = false;
            });
        },
    },
    created() {
        this.loadDefaultLang();
    },
}
</script>

<style scoped>

</style>
