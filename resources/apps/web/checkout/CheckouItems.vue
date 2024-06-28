<template>
    <div class="order-items">
        <div class="order-item">
            <div class="order-item__product order-item__header">Product</div>
            <div class="order-item__subtotal order-item__header">Subtotal</div>
        </div>
        <div class="order-item" v-for="(item,index) in items" :key="index">
            <div class="order-item__product">
                <div class="title">{{ item.title }} x {{ item.quantity }}</div>
                <div class="additional" v-if="item.meta_data.options">
                    {{ Object.values(item.meta_data.options).join(', ') }}
                </div>
            </div>
            <div class="order-item__subtotal">€{{ item.total }}</div>
        </div>
    </div>
</template>

<script>
export default {
    name: "CheckouItems",
    props: {
        items: {
            type: Array,
            required: true,
            default: () => []
        }
    }
}
</script>

<style scoped>

</style>