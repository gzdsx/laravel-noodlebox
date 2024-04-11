<template>
    <pos-dialog title="Customer profile" :visible="value" :closeable="false" @close="close">
        <div slot="header"></div>
        <div class="pos-wellcome">
            <div class="pos-wellcome-wrapper">
                <div class="pos-wellcome-item bg-primary" @click="select('local_pickup')">
                    <span class="pos-wellcome-item__icon yith-pos-icon-guest-user"></span>
                    <div class="pos-wellcome-item__name">Collection</div>
                </div>
                <div class="pos-wellcome-item bg-info" @click="select('flat_rate')">
                    <span class="pos-wellcome-item__icon yith-pos-icon-customer"></span>
                    <div class="pos-wellcome-item__name">Delivery</div>
                </div>
                <div class="pos-wellcome-item bg-yellow" @click="select('guest')">
                    <span class="pos-wellcome-item__icon yith-pos-icon-create-user"></span>
                    <div class="pos-wellcome-item__name">Guest</div>
                </div>
            </div>
        </div>
    </pos-dialog>
</template>

<script>
export default {
    name: "DialogWellcome",
    props: {
        value: Boolean,
    },
    data() {
        return {}
    },
    methods: {
        close() {
            this.$emit('input', false);
        },
        select(v) {
            this.$store.commit('setShippingMethod', v);
            this.$emit('select', v);
            this.close();
        }
    },
    mounted() {

    }
}
</script>

<style scoped>

</style>