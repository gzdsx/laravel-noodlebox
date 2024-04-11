<template>
    <div class="gzdsx-pos-number-control">
        <div class="control-btn control-btn__minus" @click="onDecrease">-</div>
        <div class="control-input">
            <input type="text" class="control-input__input" v-model="quantity" @change="quantityChanged">
        </div>
        <div class="control-btn control-btn__plus" @click="onIncrease">+</div>
    </div>
</template>

<script>
export default {
    name: "NumberControl",
    props: {
        value: {
            type: [Number, String],
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
        }
    },
    methods: {
        onDecrease() {
            if (this.quantity > 1) {
                this.quantity--;
                this.quantityChanged();
            }

            if (this.$beep) {
                this.$beep.play();
            }
        },
        onIncrease() {
            this.quantity++;
            this.quantityChanged();
            if (this.$beep) {
                this.$beep.play();
            }
        },
        quantityChanged() {
            this.$emit('input', parseInt(this.quantity));
        }
    },
    created() {
        this.quantity = this.value || 1;
    }
}
</script>

<style scoped>

</style>