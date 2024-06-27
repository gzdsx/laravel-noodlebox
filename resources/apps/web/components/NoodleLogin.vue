<template>
    <div class="dialog-login-container">
        <div class="btn-group btn-block mb-5">
            <button type="button" class="btn btn-danger" :class="{'btn-light': loginType!=='sms'}"
                    @click="loginType='sms'">By SMS OPT
            </button>
            <button type="button" class="btn btn-danger" :class="{'btn-light': loginType==='sms'}"
                    @click="loginType='password'">By Password
            </button>
        </div>

        <div class="sign-form" v-if="loginType==='sms'">
            <div class="form-group">
                <div class="input-group input-group-lg">
                    <div class="input-group-prepend">
                        <select class="form-control form-control-lg" v-model="phone.national_number">
                            <option value="353">+353</option>
                            <option value="44">+44</option>
                            <option value="86">+86</option>
                        </select>
                    </div>
                    <input type="text"
                           class="form-control"
                           placeholder="your phone number"
                           v-model="phone.phone_number"
                    >
                </div>
                <div class="invalid-feedback show" role="alert" v-html="errors.phone" v-if="errors.phone"></div>
            </div>

            <div class="form-group">
                <div class="input-group input-group-lg">
                    <input type="text"
                           class="form-control"
                           maxlength="6"
                           placeholder="verification code"
                           v-model="vercode"
                    >
                    <div class="input-group-append">
                        <button class="btn btn-light" :disabled="sending" type="button" @click="handleGetCode">
                            {{ btnGetCodeTitle }}
                        </button>
                    </div>
                </div>
                <div class="invalid-feedback show" role="alert" v-html="errors.vercode" v-show="errors.vercode"></div>
            </div>
            <div class="form-group">
                <label><input type="checkbox" v-model="remember" value="true" style="transform: scale(1.5);"> Remember
                    Me</label>
            </div>
            <div class="blank-1"></div>
            <div class="form-group">
                <button type="button" class="btn btn-danger btn-lg btn-block" :disabled="loading"
                        @click="handleLoginWithSms">Sign in
                </button>
            </div>
        </div>

        <div class="sign-form" v-else>
            <div class="form-group">
                <div class="input-group input-group-lg">
                    <div class="input-group-prepend">
                        <i class="input-group-text bi bi-envelope"></i>
                    </div>
                    <input type="email"
                           class="form-control"
                           placeholder="your email address"
                           v-model="email"
                    >
                </div>
                <div class="invalid-feedback show" role="alert" v-html="errors.email" v-if="errors.email"></div>
            </div>

            <div class="form-group">
                <div class="input-group input-group-lg">
                    <div class="input-group-prepend">
                        <i class="input-group-text bi bi-lock"></i>
                    </div>
                    <input type="password"
                           class="form-control"
                           placeholder="your password"
                           v-model="password"
                    >
                </div>
                <div class="invalid-feedback show" role="alert" v-html="errors.password" v-if="errors.password"></div>
            </div>

            <div class="form-group">
                <label><input type="checkbox" v-model="remember" value="true" style="transform: scale(1.5);"> Remember
                    Me</label>
            </div>

            <div class="blank-1"></div>
            <div class="form-group">
                <button
                        :disabled="loading"
                        @click="handleLoginWithPassword"
                        type="button"
                        class="btn btn-danger btn-lg btn-block">Sign in
                </button>
            </div>
        </div>

        <div class="auth-form-links">
            <a href="/password/reset">Forget password?</a>
            <span>or</span>
            <a href="/register">Registration</a>
        </div>

        <div class="blank-1"></div>
        <div class="auth-or">
            <span>OR</span>
        </div>
        <div class="form-group">
            <a href="/auth/google" class="btn btn-light btn-block btn-lg">
                <i class="bi bi-google"></i>
                <span>Login with Google</span>
            </a>
        </div>
        <p class="text-bull-cyan">
            <small>
                By creating an account or signing in, I agree to the
                <a href="/terms"
                   target="_blank"
                   class="text-safety-orange">Terms</a>
                of Use and have read our
                <a href="/privacy" target="_blank" class="text-safety-orange">Privacy</a> Policy.
            </small>
        </p>
    </div>
</template>

<script>
import HttpClient from "../HttpClient";
import axios from "axios";

export default {
    name: "NoodleLogin",
    data() {
        return {
            loginType: 'sms',
            loading: false,
            phone: {
                national_number: '353',
                phone_number: ''
            },
            vercode: '',
            remember: '',
            email: '',
            password: '',
            errors: {
                phone: '',
                vercode: '',
                email: '',
                password: ''
            },
            sending: false,
            btnGetCodeTitle: 'Get Code'
        }
    },
    methods: {
        handleGetCode() {
            this.errors = {};
            if (this.phone.phone_number === '') {
                this.errors.phone = 'Please enter your phone number';
                return false;
            }

            this.sending = true;
            HttpClient.post('/captcha/sms', this.phone).then(() => {
                let count = 60;
                let interval = setInterval(() => {
                    count--;
                    if (count > 0) {
                        this.btnGetCodeTitle = "Retrieve in " + count + "s";
                    } else {
                        clearInterval(interval);
                        this.btnGetCodeTitle = "Retrieve";
                        this.sending = false;
                    }
                }, 1000);
            }).catch(reason => {
                this.sending = false;
                this.errors.vercode = reason.message;
            });
        },
        handleLoginWithSms() {
            this.errors = {};
            let {phone_number, national_number} = this.phone;
            let {vercode, remember} = this;
            if (phone_number === '') {
                this.errors.phone = 'Please enter your phone number';
                return false;
            }

            if (vercode === '') {
                this.errors.vercode = 'Please enter verification code';
                return false;
            }

            this.loading = true;
            axios.post('/login/sms', {
                phone_number,
                national_number,
                vercode: this.vercode,
                remember
            }).then(() => {
                this.$emit('logined');
            }).catch(reason => {
                this.errors.vercode = reason.response.data.message;
            }).finally(() => {
                this.loading = false;
            });
        },
        handleLoginWithPassword() {
            this.errors = {};
            let {email, password, remember} = this;
            if (email === '') {
                this.errors.email = 'Please enter your email address';
                return false;
            }

            if (password === '') {
                this.errors.password = 'Please enter your password';
                return false;
            }

            this.loading = true;
            axios.post('/login', {
                email,
                password,
                remember
            }).then(() => {
                this.$emit('logined');
            }).catch(reason => {
                this.loading = false;
                this.errors.password = reason.message;
            });
        }
    }
}
</script>

<style scoped>

</style>