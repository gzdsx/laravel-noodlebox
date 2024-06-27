<template>
    <noodle-login @logined="onLogined"/>
</template>

<script>
import NoodleLogin from "./NoodleLogin.vue";

export default {
    name: "LoginApp",
    components: {NoodleLogin},
    methods: {
        onLogined() {
            if (redirectUrl) {
                window.location.assign(redirectUrl);
            } else {
                window.location.assign('/my-account');
            }
        }
    }
}
</script>

<style scoped>

</style>