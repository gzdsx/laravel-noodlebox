<template>
    <div class="number-control">
        <div class="number-control__btn" @click="onDecrease">-</div>
        <div class="number-control__input">
            <input
                    type="number"
                    class="number-control__input__input"
                    :min="1"
                    :max="100"
                    :value="quantity"
                    @change="onChange"
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
    },
    methods: {
        onInput(e) {
            console.log(e);
            //this.$emit('input', e);
            this.quantity = e.target.value;
        },
        onChange() {
            this.quantity = parseInt(this.quantity);
            if (!/^\d+$/.test(this.quantity)) {
                this.quantity = 1;
            }
            if (this.quantity < 1) {
                this.quantity = 1;
            }
            this.$emit('input', this.quantity);
            this.$emit('change', this.quantity);
        },
        onDecrease() {
            if (this.quantity > 1) {
                this.quantity--;
                this.onChange();
            }
        },
        onIncrease() {
            this.quantity++;
            this.onChange();
        }
    },
    mounted() {
        this.quantity = this.value || 1;
    }
}
</script>

<style scoped>

</style>