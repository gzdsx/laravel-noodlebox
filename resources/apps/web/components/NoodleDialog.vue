<template>
    <div class="noodle-dialog-wrapper" v-if="show" @click.prevent="clickOverlayer" @touchstart.prevent="click">
        <div
                class="noodle-dialog show"
                :class="[customClass,{'show':showAnimate}]"
                @click.stop="click"
                @touchstart.stop="click"
        >
            <slot name="header" v-if="$slots.header"/>
            <div class="noodle-dialog__header" v-else>
                <div class="flex-grow-1">
                    <h3 class="title">
                        {{ title }}
                    </h3>
                </div>
                <div class="close" @click="close">
                    <span>&times;</span>
                </div>
            </div>
            <div class="noodle-dialog__body">
                <slot/>
            </div>
            <div class="noodle-dialog__footer"></div>
        </div>
    </div>
</template>

<script>
export default {
    name: "NoodleDialog",
    props: {
        visible: {
            type: Boolean,
            default: true
        },
        title: {
            type: String,
            default: 'Dialog'
        },
        customClass: {
            type: String,
            default: ''
        },
        closeOnClick: {
            type: Boolean,
            default: true
        }
    },
    data() {
        return {
            show: false,
            showAnimate: false
        }
    },
    watch: {
        visible(val) {
            if (val !== this.show) {
                this.show = val;
            }

            if (val) {
                document.body.appendChild(this.$el);
                document.querySelector('html').classList.add('noscroll');
                this.$nextTick(() => {
                    setTimeout(() => {
                        this.showAnimate = true;
                    }, 20);
                });
            } else {
                this.showAnimate = false;
                if (this.$el && this.$el.parentNode) {
                    this.$el.parentNode.removeChild(this.$el);
                }
                document.querySelector('html').classList.remove('noscroll');
            }
        }
    },
    methods: {
        close() {
            this.$emit('close');
        },
        click() {
            return false
        },
        clickOverlayer() {
            if (this.closeOnClick) {
                this.close();
            }
        }
    },
    created() {
        this.show = this.visible;
    },
    mounted() {
        if (this.show) {
            document.body.appendChild(this.$el);
        }
    },
    destroyed() {
        if (this.$el && this.$el.parentNode) {
            this.$el.parentNode.removeChild(this.$el);
        }
    },
}
</script>

<style scoped>

</style>