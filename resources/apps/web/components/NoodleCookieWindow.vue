<script>
export default {
    name: "NoodleCookieWindow",
    methods:{
        accept(){
            this.$emit('accept');
        },
        reject(){
            this.$emit('reject');
        }
    }
}
</script>

<template>
    <div class="window-cookie">
        <div class="mb-4">
            By clicking “Accept all cookies”, you agree Noodlebox can store cookies on your device and disclose
            information in accordance with our <a href="/privacy" target="_blank">Cookie Policy</a>.
        </div>
        <div class="row justify-content-center gap-1">
            <button class="btn btn-primary" @click="accept">Accept all cookies</button>
            <button class="btn btn-secondary" @click="reject">Reject all cookies</button>
        </div>
    </div>
</template>

<style scoped>

</style>