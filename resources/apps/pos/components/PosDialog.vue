<template>
    <div class="gzdsx-pos-dialog__overlayer" v-show="show">
        <div class="gzdsx-pos-dialog" :style="{'min-width':width}">
            <div v-if="$slots.header">
                <slot name="header"/>
            </div>
            <div class="gzdsx-pos-dialog__header" v-else>
                <div class="title">{{ title }}</div>
                <div class="actions" v-if="$slots.actions">
                    <slot name="actions"/>
                </div>
                <span class="close" @click="close" v-if="closeable">&times;</span>
            </div>
            <div class="gzdsx-pos-dialog__body" ref="body">
                <slot/>
            </div>
            <slot name="footer"/>
        </div>
    </div>
</template>

<script>
export default {
    name: "PosDialog",
    props: {
        title: {
            type: String,
            default: 'Dialog'
        },
        visible: {
            type: Boolean,
            default: false
        },
        width: {
            type: String,
            default: '50%'
        },
        closeable: {
            type: Boolean,
            default: true
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
            }
        }
    },
    methods: {
        close() {
            this.$emit('close');
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