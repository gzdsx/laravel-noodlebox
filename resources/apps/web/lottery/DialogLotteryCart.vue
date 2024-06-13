<template>
    <noodle-dialog title="Your Prizes" :visible.sync="value" @close="$emit('input',false)">
        <noodle-container :loading="loading" v-if="!showCheckout">
            <div class="lottery-cart">
                <div class="lottery-cart-items">
                    <div class="lottery-cart-item" v-for="(item, index) in dataList" :key="index">
                        <div class="lottery-cart-item__image">
                            <img :src="item.image" alt="">
                        </div>
                        <div class="lottery-cart-item__name">
                            {{ item.title }}
                        </div>
                        <div class="lottery-cart-item__qty">
                            x {{ item.quantity }}
                        </div>
                    </div>
                </div>

                <div class="lottery-cart-actions">
                    <button class="btn btn-danger" @click="handleCheckout">Continue</button>
                </div>
            </div>
        </noodle-container>
    </noodle-dialog>
</template>

<script>
import HttpClient from "../HttpClient";
export default {
    name: "DialogLotteryCart",
    data() {
        return {
            dataList: [],
            loading: true,
            showCheckout: false,
        }
    },
    props: {
        value: {
            type: Boolean,
            default: false
        }
    },
    watch: {
        value(val) {
            if (val) {
                this.fetchList();
            }
        }
    },
    methods: {
        fetchList() {
            this.loading = true;
            HttpClient.get('/carts?purchase_via=lottery').then((res) => {
                this.dataList = res.data.items;
            }).finally(() => {
                this.loading = false;
            });
        },
        handleCheckout() {
            //this.showCheckout = true;
            window.location.assign('/cart')
        }
    }
}
</script>

<style scoped>

</style>