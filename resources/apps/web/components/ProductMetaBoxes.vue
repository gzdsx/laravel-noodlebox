<template>
    <div class="product-metabox">
        <h3>{{ product.title }}</h3>
        <div class="product-potins">
            Noodle Box Earn Points : 9 Points
        </div>
        <div class="product-price text-bull-cyan">€{{ product.price }}</div>
        <div class="product-description text-safety-orange" v-if="product.description">
            {{ product.description }}
        </div>
        <div class="product-variations" v-if="Array.isArray(product.variation_list)">
            <div v-for="(v,i) in product.variation_list" :key="i">
                <div class="product-variation__name">{{ v.name }}</div>
                <div class="product-variation__options">
                    <span
                            class="product-variation__option"
                            v-for="(o,j) in v.options"
                            :key="j"
                            :class="{'product-variation__option-active':o.selected}"
                            @click="onSelectOption(v,o)"
                    >{{ o.title }}</span>
                </div>
            </div>
        </div>

        <div class="product-variations"
             v-if="Array.isArray(product.additional_options) && product.additional_options.length>0">
            <div>
                <div class="product-variation__name">Additional Options</div>
                <div class="product-variation__options">
                    <span
                            class="product-variation__option"
                            v-for="(o,j) in product.additional_options"
                            :key="j"
                            :class="{'product-variation__option-active':o.selected}"
                            @click="onSelectAdditionalOption(o)"
                    >{{ o.title }}</span>
                </div>
            </div>
        </div>

        <div class="product-add-order">
            <noodle-number-control v-model="quantity"/>
            <div>
                <button class="btn btn-bull-cyan text-white" @click="addToCart">Add Order</button>
            </div>
        </div>
        <div class="product-add-favorite">
            <a>
                <i class="bi bi-heart"></i>
                <span>Add Favorite</span>
            </a>
        </div>
        <dialog-cart v-model="showCart"/>
        <noodle-loading v-if="loading"/>
    </div>
</template>

<script>
import HttpClient from "../HttpClient";
import NoodleNumberControl from "./NoodleNumberControl.vue";
import NoodleLoading from "./NoodleLoading.vue";
import DialogCart from "./DialogCart.vue";

export default {
    name: "ProductMetaBoxes",
    components: {DialogCart, NoodleLoading, NoodleNumberControl},
    props: {
        product: {
            type: Object,
            default: () => {
                return {
                    variation_list: [],
                    additional_options: []
                }
            }
        }
    },
    watch: {},
    data() {
        return {
            cart_item: {},
            meta_data: [],
            quantity: 1,
            showCart: false,
            loading: false
        }
    },
    methods: {
        onSelectOption(v, o) {
            v.options.forEach((item) => {
                item.selected = item.title === o.title;
            });
        },
        onSelectAdditionalOption(o) {
            o.selected = !o.selected;
        },
        addToCart() {
            let {product, quantity} = this;
            let meta_data = [];
            product.variation_list.forEach((item) => {
                let selected = item.options.filter((o) => o.selected);
                if (selected.length > 0) {
                    const {title, price} = selected[0];
                    meta_data.push({
                        key: item.name,
                        value: title,
                        price
                    });
                }
            });

            if (Array.isArray(product.additional_options)) {
                const options = product.additional_options.filter((item) => item.selected);
                if (options.length > 0) {
                    meta_data.push({
                        key: 'Additional Options',
                        value: options.map((item) => item.title).join(','),
                        price: options.reduce((acc, item) => acc + Number(item.price), 0)
                    });
                }
            }

            this.loading = true;
            HttpClient.post('/carts', {
                product_id: product.id,
                quantity: quantity,
                meta_data: meta_data
            }).then((res) => {
                this.showCart = true;
                this.$emit('add-cart', res);
            }).catch(reason => {
                if (reason.code === 401) {
                    window.location.href = '/login';
                }
            }).finally(() => {
                this.loading = false;
            });
        }
    }
}
</script>

<style scoped>

</style>