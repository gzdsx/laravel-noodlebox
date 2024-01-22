<template>
    <div class="admin-top">
        <div class="flex-grow-1 logo">
            <img src="/images/admin/logo.png?v=1" alt="">
            <h1>{{ $t('topbar.home') }}</h1>
        </div>
        <div class="d-flex column-gap-20">
            <div class="v-dropdown">
                <el-dropdown>
                    <a class="el-dropdown-link">
                        <img :src="userInfo.avatar" class="avatar" alt="">
                        <span>{{ userInfo.nickname }}</span>
                    </a>
                    <el-dropdown-menu slot="dropdown">
                        <el-dropdown-item>
                            <router-link to="/">{{ $t('topbar.account_set') }}</router-link>
                        </el-dropdown-item>
                        <el-dropdown-item>
                            <router-link to="/bill">{{ $t('topbar.consumption_details') }}</router-link>
                        </el-dropdown-item>
                        <el-dropdown-item>
                            <a href="/" target="_blank">{{ $t('topbar.homepage') }}</a>
                        </el-dropdown-item>
                        <el-dropdown-item divided>
                            <a @click.prevent="logout">{{ $t('topbar.logout') }}</a>
                        </el-dropdown-item>
                    </el-dropdown-menu>
                </el-dropdown>
            </div>
            <div class="v-dropdown">
                <el-dropdown @command="selectLang">
                    <a class="el-dropdown-link">
                        <i class="bi bi-translate"></i>
                        <span>{{ curLang }}</span>
                    </a>
                    <el-dropdown-menu slot="dropdown">
                        <el-dropdown-item v-for="(v,k) in languages" :command="k" :key="k">
                            {{ v }}
                        </el-dropdown-item>
                    </el-dropdown-menu>
                </el-dropdown>
            </div>
        </div>
    </div>
</template>

<script>
import AuthService from "../utils/AuthService";
import ApiService from "../utils/ApiService";

export default {
    name: "TopBar",
    data() {
        return {
            languages: {
                'zh_CN': '简体中文',
                'en': 'English'
            },
            curLang: ''
        }
    },
    computed: {
        userInfo() {
            return this.$store.state.userInfo;
        }
    },
    methods: {
        logout() {
            AuthService.removeToken();
            this.$router.replace('/login');
        },
        selectLang(lang) {
            ApiService.get('/lang/messages/' + lang).then(response => {
                const {locale, messages} = response.result;
                this.$i18n.setLocaleMessage('locale', messages);
                this.curLang = this.languages[lang];
            });
        },
    },
    mounted() {
        this.curLang = this.languages[this.$lang];
        if (AuthService.getToken()) {
            ApiService.get('/user/info').then(response => {
                this.$store.commit('signin', response.result);
            });
        }

        ApiService.get('/lang/locale').then(response => {
            this.$lang = response.result;
            this.curLang = this.languages[this.$lang];
        });
    }
}
</script>

<style scoped>

</style>
