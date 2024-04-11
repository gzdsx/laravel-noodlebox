<template>
    <div class="pos-input__wrapper">
        <div class="pos-input" :class="{'pos-input__invalid':invalid}">
            <div class="pos-input__prepend" v-if="$slots.prepend">
                <slot name="prepend"/>
            </div>
            <div class="pos-input__content" v-if="$slots.input">
                <slot name="input"/>
            </div>
            <div class="pos-input__content" v-else>
                <input
                        v-bind="$attrs"
                        autocomplete="off"
                        aria-autocomplete="none"
                        class="pos-input__input"
                        :class="{'text-right':align==='right','text-center':align==='center'}"
                        @input="handleInput"
                        @change="handleChange"
                        @focus="handleFocus"
                        @blur="handleBlur"
                        @compositionstart="handleCompositionStart"
                        @compositionupdate="handleCompositionUpdate"
                        @compositionend="handleCompositionEnd"
                />
            </div>
            <div class="pos-input__append" v-if="$slots.append">
                <slot name="append"/>
            </div>
        </div>
        <div class="pos-invalid-feedback" v-if="invalid" v-html="errMessage"></div>
    </div>
</template>

<script>
export default {
    name: "PosInput",
    props: {
        invalid: false,
        errMessage: {
            type: String,
            default: 'This field is required'
        },
        align: {
            type: String,
            default: 'left'
        }
    },
    data() {
        return {
            isComposing: false
        }
    },
    methods: {
        handleInput(event) {
            if (this.isComposing) return;
            this.$emit('input', event.target.value);
            this.$emit('inputChange', event.target.value);
        },
        handleChange(event) {
            this.$emit('change', event.target.value);
        },
        handleFocus(event) {
            this.$emit('focus', event);
        },
        handleBlur(event) {
            this.$emit('blur', event);
        },
        handleCompositionStart(event) {
            this.isComposing = true;
        },
        handleCompositionUpdate(event) {

        },
        handleCompositionEnd(event) {
            if (this.isComposing) {
                this.isComposing = false;
                this.handleInput(event);
            }
        },
    }
}
</script>

<style scoped>

</style>