<template>
    <div class="number-control">
        <div class="number-control__btn" @click="onDecrease">-</div>
        <div class="number-control__input">
            <input
                    type="number"
                    class="number-control__input__input"
                    :min="1"
                    :max="100"
                    v-model="quantity"
                    @change="onInput"
            >
        </div>
        <div class="number-control__btn" @click="onIncrease">+</div>
    </div>
</template>

<script>
export default {
    name: "NoodleNumberControl",
    props: {
        value: {
            type: Number,
            default: 1
        }
    },
    data() {
        return {
            quantity: 1
        }
    },
    watch: {
        value(val) {
            if (val !== this.quantity) {
                this.quantity = val;
            }
        },
        quantity(val) {
            this.$emit('change', val);
        }
    },
    methods: {
        onInput() {
            if (!/\d+/.test(this.quantity)) {
                this.quantity = 1;
            }
            if (this.quantity < 1) {
                this.quantity = 1;
            }
            this.$emit('input', this.quantity);
        },
        onDecrease() {
            if (this.quantity > 1) {
                this.quantity--;
                this.onInput();
            }
        },
        onIncrease() {
            this.quantity++;
            this.onInput();
        }
    },
    mounted() {
        this.quantity = this.value || 1;
    }
}
</script>

<style scoped>

</style>