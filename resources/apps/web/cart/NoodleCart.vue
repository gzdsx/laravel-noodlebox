<template>
    <div class="container">
        <div class="row" v-if="!loading">
            <div class="col-12 col-md-8">
                <div class="cart-items">
                    <div class="cart-item" v-for="(item,index) in cart_items" :key="index">
                        <div class="cart-item__remove">
                            <i class="bi bi-x-circle" @click="removeItem(index)"></i>
                        </div>
                        <div class="cart-item__image">
                            <img :src="item.image" alt="">
                        </div>
                        <div class="cart-item__main">
                            <div class="cart-item__title">
                                <div class="title">{{ item.title }}</div>
                                <div class="metas">
                                    {{ metaValue(item.options) }}
                                </div>
                            </div>
                            <div class="cart-item__price text-bull-cyan">€{{ item.price }}</div>
                            <div class="cart-item__qty">
                                <noodle-number-control v-model="item.quantity" @change="onQuantityChange(index)"/>
                            </div>
                        </div>
                        <div class="cart-item__total text-bull-cyan">€{{ item.subtotal }}</div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="cart-totals">
                    <div class="cart-total">
                        <div class="cart-total__label cart-total__total">Cart Total</div>
                        <div class="cart-total__value">€{{ total }}</div>
                    </div>
                </div>
                <div class="cart-actions">
                    <div class="cart-action">
                        <button class="btn btn-danger btn-lg text-uppercase" @click="onCheckout">Check Out</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import NoodleNumberControl from "../components/NoodleNumberControl.vue";
import CartService from "../CartService";

const cart = new CartService();
export default {
    name: "NoodleCart",
    components: {NoodleNumberControl},
    data() {
        return {
            visible: false,
            cart_items: [],
            loading: false
        }
    },
    computed: {
        total() {
            let total = 0;
            this.cart_items.forEach((item) => {
                total += parseFloat(item.subtotal);
            });
            return total.toFixed(2);
        }
    },
    methods: {
        close() {
            this.$emit('input', false);
        },
        removeItem(index) {
            this.cart_items.splice(index, 1);
            const cartItems = cart.getCartItems();
            cartItems.splice(index, 1);
            cart.saveItems(cartItems);
        },
        onQuantityChange(index) {
            let item = this.cart_items[index];
            let cartItems = cart.getCartItems();
            cartItems[index].quantity = item.quantity;
            cart.saveItems(cartItems);
        },
        onCheckout() {
            window.location.assign('/checkout');
        },
        metaValue(options) {
            return Object.values(options).join(',');
        },
    },
    mounted() {
        this.cart_items = cart.getCartItems();
    }
}
</script>

<style scoped>

</style>