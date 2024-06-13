<template>
    <div class="container">
        <noodle-container :loading="loading">
            <div class="row">
                <div class="col-12 col-md-8">
                    <div class="cart-items">
                        <div class="cart-item" v-for="(item,index) in cart_items" :key="index">
                            <div class="cart-item__remove">
                                <i class="bi bi-x-circle" @click="removeItem(item)"></i>
                            </div>
                            <div class="cart-item__image">
                                <img :src="item.image" alt="">
                            </div>
                            <div class="cart-item__main">
                                <div class="cart-item__title">
                                    <div class="title">{{ item.title }}</div>
                                    <div class="metas" v-if="item.options">
                                        {{ Object.values(item.options).join(', ') }}
                                    </div>
                                    <div class="metas"
                                         v-if="item.additional_options &&item.additional_options.length">
                                        {{ item.additional_options.join(', ') }}
                                    </div>
                                    <div class="text-safety-orange font-weight-bold" v-if="item.purchase_with_point">
                                        Points: {{ item.pointTotal }}
                                    </div>
                                </div>
                                <div class="cart-item__price text-bull-cyan">€{{ item.price }}</div>
                                <div class="cart-item__qty text-safety-orange"
                                     v-if="item.purchase_via==='point'||item.purchase_via==='lottery'">
                                    {{ item.quantity }}
                                </div>
                                <div class="cart-item__qty" v-else>
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
        </noodle-container>
    </div>
</template>

<script>
import NoodleNumberControl from "../components/NoodleNumberControl.vue";
import CartService from "../CartService";
import HttpClient from "../HttpClient";

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
        removeItem(item) {
            let {id} = item;
            HttpClient.delete('/carts/' + id).then((res) => {
                window.dispatchEvent(new Event('cartChanged'));
                this.cart_items = this.cart_items.filter((item) => item.id !== id);
            }).finally(() => {

            });
        },
        onQuantityChange(index) {
            let {id, quantity} = this.cart_items[index];
            //this.loading = true;
            HttpClient.put('/carts/' + id, {quantity}).finally(() => {
                //this.loading = false;
            });
        },
        onCheckout() {
            window.location.assign('/checkout');
        },
        fetchCartItems() {
            this.loading = true;
            HttpClient.get('/carts').then((res) => {
                res.data.items.forEach((item) => {
                    let meta_data = item.meta_data;
                    if (meta_data) {
                        if (meta_data.options) {
                            item.options = meta_data.options;
                        }
                        if (meta_data.additional_options) {
                            item.additional_options = meta_data.additional_options;
                        }
                    }

                    Object.defineProperty(item, 'subtotal', {
                        get() {
                            return (Number(this.price) * Number(this.quantity)).toFixed(2);
                        }
                    });

                    Object.defineProperty(item, 'pointTotal', {
                        get() {
                            if (this.product) {
                                return (Number(this.product.point_price) * Number(this.quantity)).toFixed(2);
                            }

                            return 0;
                        }
                    });
                });
                this.cart_items = res.data.items;
            }).finally(() => {
                this.loading = false;
            });
        }
    },
    mounted() {
        this.fetchCartItems();
    }
}
</script>

<style scoped>

</style>