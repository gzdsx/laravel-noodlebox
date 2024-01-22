<template>
    <div class="admin-login">
        <div class="form-wrapper">
            <h1 class="form-header">{{ $t('login.system_login') }}</h1>
            <el-form>
                <el-form-item>
                    <el-input
                        :placeholder="$t('login.account_tips')"
                        v-model="account"
                    >
                        <div class="svg" slot="prepend">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                 class="bi bi-person-fill" viewBox="0 0 16 16">
                                <path
                                    d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"></path>
                            </svg>
                        </div>
                    </el-input>
                </el-form-item>
                <el-form-item>
                    <el-input
                        :placeholder="$t('login.password_tips')"
                        v-model="password"
                        type="password"
                    >
                        <div class="svg" slot="prepend">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                 class="bi bi-key-fill" viewBox="0 0 16 16">
                                <path
                                    d="M3.5 11.5a3.5 3.5 0 1 1 3.163-5H14L15.5 8 14 9.5l-1-1-1 1-1-1-1 1-1-1-1 1H6.663a3.5 3.5 0 0 1-3.163 2zM2.5 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2"></path>
                            </svg>
                        </div>
                    </el-input>
                </el-form-item>
                <el-form-item>
                    <el-button class="w-100" type="primary" @click="submit">{{ $t('login.login') }}</el-button>
                </el-form-item>
            </el-form>
        </div>
    </div>
</template>

<script>
import ApiService from "../utils/ApiService";
import AuthService from "../utils/AuthService";

export default {
    name: "Login",
    data() {
        return {
            account: '',
            password: ''
        }
    },
    created() {
        //document.body.style.backgroundColor = '#2E3A4D';
    },
    methods: {
        submit() {
            const {account, password} = this;
            if (!account) {
                this.$message.error(this.$t('login.please enter account'));
                return false;
            }

            if (!password) {
                this.$message.error(this.$t('login.please enter password'));
                return false;
            }

            ApiService.post('/login', {account, password}).then(response => {
                const {access_token} = response.result;
                if (access_token) {
                    AuthService.updateToken(access_token);
                    this.$router.replace('/');
                }
            }).catch(reason => {
                this.$message.error(reason.message);
            }).finally(() => {

            });
        }
    }
}
</script>

<style scoped>

</style>
