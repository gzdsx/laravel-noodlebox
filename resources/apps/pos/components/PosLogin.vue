<template>
    <div class="pos-login__wrapper">
        <div class="pos-login__box">
            <div class="pos-login__logo">
                <img src="/images/noodlebox/pos-logo.png" alt="">
            </div>
            <div class="form-group">
                <pos-input
                        placeholder="Username/Email"
                        v-model="account"
                >
                    <div slot="prepend">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                             class="bi bi-person-fill" viewBox="0 0 16 16">
                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                        </svg>
                    </div>
                </pos-input>
            </div>
            <div class="form-group">
                <pos-input
                        type="password"
                        placeholder="Password"
                        v-model="password"
                >
                    <div slot="prepend">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                             class="bi bi-key-fill" viewBox="0 0 16 16">
                            <path d="M3.5 11.5a3.5 3.5 0 1 1 3.163-5H14L15.5 8 14 9.5l-1-1-1 1-1-1-1 1-1-1-1 1H6.663a3.5 3.5 0 0 1-3.163 2M2.5 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
                        </svg>
                    </div>
                </pos-input>
            </div>
            <div class="form-group pos-invalid-feedback" v-if="errorMsg" v-html="errorMsg"></div>
            <div class="form-group">
                <button class="btn btn-primary btn-block" @click="login">Login</button>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: "PosLogin",
    data() {
        return {
            account: '',
            password: '',
            logining: false,
            errorMsg: null
        }
    },
    computed: {
        disabled() {
            return this.account.length === 0 || this.password.length === 0 || this.logining;
        }
    },
    mounted() {
        document.body.appendChild(this.$el);
    },
    destroyed() {
        if (this.$el && this.$el.parentNode) {
            this.$el.parentNode.removeChild(this.$el);
        }
    },
    methods: {
        login() {
            const {account, password} = this;
            this.$http.post('auth/adminlogin', {account, password}).then(resp => {
                localStorage.setItem('accessToken', resp.data.access_token);
                this.$store.commit('setIsLoggedIn', true);
            }).catch(err => {

            }).finally(() => {
                this.logining = false;
            });
        }
    }
}
</script>

<style scoped>

</style>