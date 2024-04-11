<template>
    <div class="pos-color-picker">
        <div class="pos-color-picker__color" v-for="color in colors" :style="{background: color}" @click.stop="clickColor(color)"></div>
    </div>
</template>

<script>
const defaultColors = [
    '#FF6900', '#FCB900', '#7BDCB5', '#00D084', '#8ED1FC', '#0693E3', '#ABB8C3',
    '#EB144C', '#F78DA7', '#9900EF'
]
export default {
    name: "PosColorPicker",
    props: {
        value: {
            type: String,
            default: '#6c757d'
        }
    },
    data() {
        return {
            theColor: this.value,
            colors: defaultColors
        }
    },
    methods: {
        clickColor(color) {
            this.theColor = color;
            this.$emit('input', color);
            this.$emit('select', color);
        }
    }
}
</script>

<style scoped>

</style>