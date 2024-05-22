<template>
    <noodle-dialog title="Login" custom-class="auth-dialog" :visible="value" @close="close">
        <div class="dialog-login-wapper">
            <form method="post" class="auth-form">
                <div class="form-group">
                    <input
                            type="text"
                            class="form-control form-control-lg"
                            placeholder="Phone/Email"
                            required="required"
                            v-model="account"
                    >
                </div>
                <div class="form-group">
                    <input
                            type="password"
                            class="form-control form-control-lg"
                            placeholder="Password"
                            required="required"
                            v-model="password"
                    >
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-danger btn-lg btn-block" @click="login">Login</button>
                </div>
                <div class="auth-form-links">
                    <a href="/">Forget password?</a>
                    <span>or</span>
                    <a href="/register">Registration</a>
                </div>
            </form>

            <div class="blank-1"></div>
            <div class="auth-or">
                <span>OR</span>
            </div>

            <div class="auth-socials">
                <a href="/auth/google">
                    <i class="bi bi-google"></i>
                </a>
                <a href="/auth/facebook">
                    <i class="bi bi-facebook"></i>
                </a>
                <a href="/auth/github">
                    <i class="bi bi-github"></i>
                </a>
                <a href="/auth/bi-twitter">
                    <i class="bi bi-twitter"></i>
                </a>
            </div>
        </div>
    </noodle-dialog>
</template>

<script>
import HttpClient from "../HttpClient";

export default {
    name: "NoodleDialogLogin",
    props: {
        value: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            account: '',
            password: ''
        }
    },
    methods: {
        login() {
            const {account, password} = this;
            HttpClient.post('/login', {
                account,
                password
            }).then((res) => {
                this.$emit('input', false);
            }).catch(reason => {
                console.log(reason);
            }).finally(() => {

            });
        },
        close() {
            this.$emit('input', false);
        }
    }
}
</script>

<style scoped>

</style>