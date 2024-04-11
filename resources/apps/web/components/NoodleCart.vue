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
                                <div class="options">
                                    <span>Points: 9</span>
                                    <a>Additional options</a>
                                </div>
                            </div>
                            <div class="cart-item__price text-bull-cyan">€{{ item.price }}</div>
                            <div class="cart-item__qty">
                                <noodle-number-control v-model="item.quantity" @change="onQuantityChange(index)"/>
                            </div>
                        </div>
                        <div class="cart-item__total text-bull-cyan">€{{ item.total }}</div>
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
import NoodleNumberControl from "./NoodleNumberControl.vue";
import HttpClient from "../HttpClient";

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
                total += parseFloat(item.total);
            });
            return total.toFixed(2);
        }
    },
    methods: {
        close() {
            this.$emit('input', false);
        },
        fetchList() {
            this.loading = true;
            HttpClient.get('/carts').then((res) => {
                res.data.items.forEach((item) => {
                    Object.defineProperty(item, 'total', {
                        get() {
                            return (this.price * this.quantity).toFixed(2);
                        },
                    });
                });
                this.cart_items = res.data.items;
            }).catch(reason => {

            }).finally(() => {
                this.loading = false;
            });
        },
        removeItem(index) {
            let item = this.cart_items[index];
            HttpClient.delete(`/carts/${item.id}`).then((res) => {
                this.cart_items.splice(index, 1);
            }).catch(reason => {

            }).finally(() => {

            });
        },
        onQuantityChange(index) {
            let item = this.cart_items[index];
            let {quantity, id} = item;
            //this.loading = true;
            HttpClient.put(`/carts/${id}`, {
                quantity: quantity
            }).then((res) => {

            }).catch(reason => {

            }).finally(() => {
                //this.loading = false;
            });
        },
        onCheckout() {
            window.location.href = '/checkout';
        }
    },
    mounted() {
        this.fetchList();
    }
}
</script>

<style scoped>

</style>