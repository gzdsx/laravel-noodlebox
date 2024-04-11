<template>
    <div class="pos-number-pad">
        <button class="number-button" @click="addNumber(1)">1</button>
        <button class="number-button" @click="addNumber(2)">2</button>
        <button class="number-button" @click="addNumber(3)">3</button>
        <button class="number-button" @click="clear">Clear</button>
        <button class="number-button" @click="addNumber(4)">4</button>
        <button class="number-button" @click="addNumber(5)">5</button>
        <button class="number-button" @click="addNumber(6)">6</button>
        <button class="number-button" @click="backspace">
            <i class="yith-pos-icon-backspace"></i>
        </button>
        <button class="number-button" @click="addNumber(7)">7</button>
        <button class="number-button" @click="addNumber(8)">8</button>
        <button class="number-button" @click="addNumber(9)">9</button>
        <button class="number-button number-button__submit" @click="submit">{{ submitLabel }}</button>
        <button class="number-button" @click="addNumber(0)">0</button>
        <button class="number-button" @click="addNumber('.')">.</button>
        <button class="number-button" @click="addNumber('00')">00</button>
        <button class="number-button number-button__back" @click="back">BACK</button>
    </div>
</template>

<script>
export default {
    name: "NumberPad",
    props: {
        submitLabel: {
            type: String,
            default: 'pay'
        },
        value: {
            type: [Number, String],
            default: ''
        }
    },
    watch: {
        value(val) {
            if (val !== this.content) {
                this.content = val;
            }
        }
    },
    data() {
        return {
            content: ''
        }
    },
    methods: {
        addNumber(n) {
            let {content} = this;
            if (n === '.' && content.indexOf('.') !== -1) {
                return
            }

            if (content === '0' && n !== '.') {
                content = '';
            }

            this.content = `${content}${n}`;
            this.change();
        },
        clear() {
            this.content = '0';
            this.change();
        },
        submit() {
            this.$emit('submit', this.content);
        },
        back() {
            this.$emit('back', this.content);
        },
        backspace() {
            this.content = this.content.substring(0, this.content.length - 1);
            this.change();
        },
        change() {
            const content = this.content;
            this.$emit('change', content);
            this.$emit('input', content);
        }
    },
    created() {
        this.content = this.value;
    }
}
</script>

<style scoped>

</style>