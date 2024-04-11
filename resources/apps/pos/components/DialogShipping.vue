<template>
    <pos-dialog title="Add Shipping" :visible="value" @close="close">
        <div class="pos-customer-row column-gap-2">
            <div class="form-group pos-customer-col">
                <div class="form-input-label">Shipping Method</div>
                <div>
                    <select class="form-control custom-select" v-model="shipping_method">
                        <option v-for="(m,idx) in shipping_methods" :value="m" :key="idx">{{ m.title }}</option>
                    </select>
                </div>
            </div>
            <div class="form-group pos-customer-col">
                <div class="form-input-label">Amount</div>
                <div>
                    <input type="text" class="form-control text-right" v-model="amount">
                </div>
            </div>
        </div>
        <number-pad submit-label="update shipping" @change="change" @submit="update" @back="close"/>
    </pos-dialog>
</template>

<script>
import NumberPad from "./NumberPad.vue";

export default {
    name: "DialogShipping",
    components: {NumberPad},
    props: {
        value: Boolean,
    },
    data() {
        return {
            amount: '0',
            shipping_method: {},
            shipping_methods: [],
        }
    },
    methods: {
        close() {
            this.$emit('input', false);
        },
        update() {
            const {amount} = this;
            const {id, title} = this.shipping_method;

            this.$emit('submit', {
                method_id: id,
                method_title: title,
                total: amount
            });
            this.close();
        },
        change(v) {
            this.amount = v;
        }
    },
    mounted() {
        this.$http.get('shipping_methods').then(response => {
            this.shipping_methods = response;
            this.shipping_method = this.shipping_methods[0];
        });
    }
}
</script>

<style scoped>

</style>