<template>
    <noodle-dialog title="Lottery" :visible="visible" @close="close">
        <lucky-box/>
    </noodle-dialog>
</template>

<script>
import LuckyBox from "./LuckyBox.vue";

export default {
    name: "DialogLottery",
    components: {LuckyBox},
    props: {
        value: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            visible: true,
            prize: null,
        }
    },
    watch: {
        value(val) {
            if (val !== this.visible) {
                this.visible = val;
            }
        }
    },
    methods: {
        close() {
            this.$emit('input', false);
        },
    },
    mounted() {
        this.$nextTick(() => {
            this.visible = true;
        });
    }
}
</script>

<style scoped>

</style>