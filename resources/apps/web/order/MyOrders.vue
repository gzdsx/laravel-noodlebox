<template>
    <div>
        <div class="my-orders">
            <div class="order-item" v-for="(order,index) in orders" :key="index">
                <div class="order-item__header">
                    <div class="order-item__number">
                        {{ order.created_at }}
                    </div>
                    <div class="order-item__status">{{ order.status }}</div>
                </div>
                <div class="order-item__items">
                    <div class="order-item__item" v-for="(item,idx) in order.items" :key="idx">
                        <div class="order-item__thumbnail">
                            <img :src="item.image" alt="">
                        </div>
                        <div class="order-item__title">
                            <div class="title">{{ item.title }}</div>
                            <small class="text-muted" v-if="item.meta_data&&item.meta_data.options">
                                {{ Object.values(item.meta_data.options).join(',') }}
                            </small>
                            <small class="text-muted" v-if="item.meta_data&&item.meta_data.additional_options">
                                {{ item.meta_data.additional_options.join(',') }}
                            </small>
                            <small class="text-muted" v-if="item.meta_data&&item.meta_data.purchase_via">
                                via {{ item.meta_data.purchase_via }}
                            </small>
                        </div>
                        <div class="order-item__price">
                            <strong>€{{ item.price }}</strong>
                            <span>x{{ item.quantity }}</span>
                        </div>
                    </div>
                </div>
                <div class="order-item__totals">
                    Total: €{{ order.total }} (Shipping Total: €{{ order.shipping_total }})
                </div>
                <div class="order-item__footer">
                    <button class="btn btn-outline-light btn-sm" @click="addCart(order)">Order Again</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import HttpClient from "../HttpClient";
import OrderTabs from "./OrderTabs.vue";

export default {
    name: "MyOrders",
    components: {OrderTabs},
    data() {
        return {
            loading: true,
            orders: [],
            status: 'all'
        }
    },
    methods: {
        fetchList() {
            this.loading = true;
            HttpClient.get('/orders?status=' + this.status).then((res) => {
                this.orders = res.data.items;
            }).catch(reason => {

            }).finally(() => {
                this.loading = false;
            });
        },
        onTabChange(tab) {
            this.status = tab;
            this.fetchList();
        },
        addCart(order) {
            HttpClient.post(`/orders/${order.id}/purchase`).then(response => {
                //this.$showToast('Order placed successfully');
                window.location.assign('/cart');
            });
        }
    },
    mounted() {
        this.fetchList();
    }
}
</script>

<style scoped>

</style>