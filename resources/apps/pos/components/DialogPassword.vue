<template>
    <div class="pos-login__wrapper">
        <div class="pos-login__box">
            <i class="times-close" @click="close">&times;</i>
            <div class="pos-login__logo">
                <img src="https://noodlebox.ie/wp-content/uploads/2019/03/noodlebox-2.png" alt="">
            </div>
            <div class="form-group">
                <pos-input
                        type="password"
                        placeholder="Password"
                        v-model="password"
                />
            </div>
            <div class="form-group pos-invalid-feedback" v-if="errorMsg" v-html="errorMsg"></div>
            <div class="form-group">
                <button class="btn btn-primary btn-block" :disabled="disabled" @click="login">Confirm</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "DialogPassword",
    data() {
        return {
            password: '',
            errorMsg: null
        }
    },
    computed: {
        disabled() {
            return this.password.length === 0;
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
        close() {
            this.$emit('close');
        },
        login() {
            const {password} = this;
            this.errorMsg = null;
            if (password === '123456') {
                this.$emit('logined');
            } else {
                this.errorMsg = 'Password is wrong';
            }
        }
    }
}
</script>

<style scoped>

</style>