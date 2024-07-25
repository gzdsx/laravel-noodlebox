<template>
    <div>
        <noodle-dialog title="" :visible="visible" @close="visible=false">
            <div slot="header"></div>
            <noodle-container :loading="loading">
                <div class="dialog-metas-container position-relative">
                    <div class="row flex-column flex-md-row">
                        <div class="col product-image-col">
                            <div class="product-images-wrapper">
                                <img :src="curImage.image" alt="">
                                <div class="product-thumbs">
                                    <div class="product-thumb"
                                         v-for="(image, index) in product.images"
                                         :key="index"
                                         @click="curImage=image"
                                    >
                                        <img :src="image.image" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col product-col-metas">
                            <product-meta-boxes
                                :product="product"
                                @added="visible=false"
                            />
                        </div>
                    </div>
                </div>
                <div class="close-meta" @click="close">
                    <span>&times;</span>
                </div>
            </noodle-container>
        </noodle-dialog>
        <noodle-dialog-login v-model="showLogin" @close="showLogin=false"/>
        <lottery-app/>
        <noodle-cookie-window v-if="showCookie" @reject="showCookie=false" @accept="onAcceptCookie"/>
    </div>
</template>

<script>
import HttpClient from "../HttpClient";
import DialogCart from "./DialogCart.vue";
import ProductMetaBoxes from "./ProductMetaBoxes.vue";
import NoodleDialog from "./NoodleDialog.vue";
import NoodleLoading from "./NoodleLoading.vue";
import NoodleDialogLogin from "./NoodleDialogLogin.vue";
import CartService from "../CartService";
import DialogLottery from "../lottery/DialogLottery.vue";
import LotteryApp from "../lottery/LotteryApp.vue";
import NoodleCookieWindow from "./NoodleCookieWindow.vue";

export default {
    name: "NoodleBoxApp",
    components: {
        NoodleCookieWindow,
        LotteryApp, DialogLottery, NoodleDialogLogin, NoodleLoading, NoodleDialog, ProductMetaBoxes, DialogCart
    },
    data() {
        return {
            visible: false,
            loading: false,
            product: {},
            curImage: {},
            showLogin: false,
            showCookie: false
        }
    },
    methods: {
        close() {
            this.visible = false;
        },
        onAcceptCookie() {
            window.localStorage.setItem('CookieStatus', 'yes');
            this.showCookie = false;
        }
    },
    mounted() {
        let items = document.querySelectorAll('.add-to-cart');
        items.forEach(item => {
            item.addEventListener('click', (e) => {
                if (!window.noodlebox.user.id) {
                    this.showLogin = true;
                    return false;
                }
                const id = e.target.getAttribute('data-id');
                this.loading = true;
                HttpClient.get(`/products/${id}`).then(response => {
                    this.product = response.data;
                    this.curImage = response.data.images[0];
                    this.visible = true;
                }).catch(reason => {
                    if (reason.code === 401) {
                        window.location.href = '/login';
                    }
                }).finally(() => {
                    this.loading = false;
                });
            });
        });

        let cart = new CartService();
        document.querySelectorAll('.cart-count').forEach(item => {
            item.innerHTML = cart.getCount();
        });

        // 监听自定义事件
        window.addEventListener('unauthenticated', (event) => {
            //console.log('你尚未登录');
            //window.location.href = '/login?redirect=' + window.location.href;
            this.showLogin = true;
        });

        try {
            this.showCookie = window.localStorage.getItem('CookieStatus') !== 'yes';
        } catch (e) {

        }
    }
}
</script>

<style scoped>
.close-meta {
    position: absolute;
    color: #ffffff;
    font-size: 24px;
    top: 0;
    right: 16px;
    padding: 3px;
    cursor: pointer;
}
</style>