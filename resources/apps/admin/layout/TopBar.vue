<template>
    <div class="admin-top">
        <div class="flex-grow-1 logo">
            <img src="/images/admin/logo.png?v=1" alt="">
            <h1>{{ $t('topbar.home') }}</h1>
        </div>
        <div class="d-flex column-gap-20">
            <div class="v-dropdown">
                <el-dropdown @command="onCommand">
                    <a class="el-dropdown-link">
                        <img :src="userInfo.avatar" class="avatar" alt="">
                        <span>{{ userInfo.nickname }}</span>
                    </a>
                    <el-dropdown-menu slot="dropdown">
                        <el-dropdown-item :command="{to:'/'}">
                            {{ $t('topbar.account_set') }}
                        </el-dropdown-item>
                        <el-dropdown-item :command="{to:'/bill'}">
                            {{ $t('topbar.consumption_details') }}
                        </el-dropdown-item>
                        <el-dropdown-item :command="{href:'/'}">
                            {{ $t('topbar.homepage') }}
                        </el-dropdown-item>
                        <el-dropdown-item :command="{event:'logout'}" divided>
                            {{ $t('topbar.logout') }}
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
            ApiService.get('/locale/messages/' + lang).then(response => {
                const {locale, messages} = response.data;
                this.$i18n.setLocaleMessage('locale', messages);
                this.curLang = this.languages[lang];
            });
        },
        onCommand(cmd) {
            if (cmd.event === 'logout') {
                this.logout()
            }

            if (cmd.to) {
                this.$router.push(cmd.to);
            }

            if (cmd.href) {
                window.open(cmd.href);
            }
        }
    },
    mounted() {
        this.curLang = this.languages[this.$lang];
        if (AuthService.getToken()) {
            ApiService.get('/user/info').then(response => {
                this.$store.commit('signin', response.data);
            });
        }

        ApiService.get('/locale').then(response => {
            this.$lang = response.data;
            this.curLang = this.languages[this.$lang];
        });
    }
}
</script>

<style scoped>

</style>
