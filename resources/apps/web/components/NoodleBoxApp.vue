<template>
    <div>
        <noodle-dialog title="Add to cart" :visible="visible" @close="visible=false">
            <noodle-container :loading="loading">
                <div class="dialog-metas-container">
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
                        <div class="col">
                            <product-meta-boxes
                                    :product="product"
                                    @add-cart="visible=false"
                            />
                        </div>
                    </div>
                </div>
            </noodle-container>
        </noodle-dialog>
        <noodle-dialog-login v-model="showLogin" @close="showLogin=false"/>
    </div>
</template>

<script>
import HttpClient from "../HttpClient";
import DialogCart from "./DialogCart.vue";
import ProductMetaBoxes from "./ProductMetaBoxes.vue";
import NoodleDialog from "./NoodleDialog.vue";
import NoodleLoading from "./NoodleLoading.vue";
import NoodleDialogLogin from "./NoodleDialogLogin.vue";

export default {
    name: "NoodleBoxApp",
    components: {NoodleDialogLogin, NoodleLoading, NoodleDialog, ProductMetaBoxes, DialogCart},
    data() {
        return {
            visible: false,
            loading: false,
            product: {},
            curImage: {},
            showLogin: false
        }
    },
    mounted() {
        let items = document.querySelectorAll('.add-to-cart');
        items.forEach(item => {
            item.addEventListener('click', (e) => {
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


        // 监听自定义事件
        window.addEventListener('unauthenticated', (event) => {
            console.log('你尚未登录');
            //window.location.href = '/login';
            this.showLogin = true;
        });
    }
}
</script>

<style scoped>

</style>