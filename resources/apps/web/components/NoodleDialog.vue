<template>
    <div class="noodle-dialog-wrapper" v-show="show" @click="close">
        <div class="noodle-dialog" :class="customClass" @click.stop="click">
            <div class="noodle-dialog__header">
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
        }
    },
    data() {
        return {
            show: false
        }
    },
    watch: {
        visible(val) {
            if (val !== this.show) {
                this.show = val;
            }

            if (val) {
                document.body.appendChild(this.$el);
            } else {
                if (this.$el && this.$el.parentNode) {
                    this.$el.parentNode.removeChild(this.$el);
                }
            }
        }
    },
    methods: {
        close() {
            this.$emit('close');
        },
        click() {

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