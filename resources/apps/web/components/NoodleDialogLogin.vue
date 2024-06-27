<template>
    <noodle-dialog title="Login" custom-class="auth-dialog" :visible="value" :close-on-click="false" @close="close">
        <noodle-login @logined="onLogined"/>
    </noodle-dialog>
</template>

<script>
import NoodleLogin from "./NoodleLogin.vue";

export default {
    name: "NoodleDialogLogin",
    components: {NoodleLogin},
    props: {
        value: {
            type: Boolean,
            default: false
        }
    },
    methods: {
        close() {
            this.$emit('input', false);
        },
        onLogined(){
            window.location.reload();
        }
    }
}
</script>

<style scoped>

</style>