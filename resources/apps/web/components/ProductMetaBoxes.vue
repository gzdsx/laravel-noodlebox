<template>
    <div class="product-metabox">
        <div class="product-sticky">
            <div class="product-thumbnail">
                <img :src="product.image" alt="">
            </div>
            <div class="product-info">
                <h3 class="product-name">{{ product.title }}</h3>
                <div class="product-potins">
                    Earn Points : {{ product.points }} Points
                </div>
                <div class="product-price text-bull-cyan" v-if="!usePointPurchase">€{{ finalPrice }}</div>
            </div>
        </div>

        <div class="product-description text-safety-orange" v-html="product.description"
             v-if="product.description"></div>
        <div class="product-badges" v-if="product.meta_data.badges">
            <img v-for="(b,i) in product.meta_data.badges" :key="i" :src="b" alt="">
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

        <div class="mt-4" v-if="product.allow_point_purchase">
            <label class="text-safety-orange">
                <input type="checkbox" v-model="usePointPurchase"
                       style="transform: scale(1.5); margin-right: 3px; margin-left: 6px;">
                <span>Use {{ totalPoints }} Noodle Box Points for purchasing this Product</span>
            </label>
        </div>

        <div class="product-add-order">
            <noodle-number-control v-model="quantity"/>
            <div>
                <button class="btn btn-danger text-white" @click="addToCart">Add Order</button>
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
import NoodleNumberControl from "./NoodleNumberControl.vue";
import NoodleLoading from "./NoodleLoading.vue";
import DialogCart from "./DialogCart.vue";
import CartService from "../CartService";
import HttpClient from "../HttpClient";

export default {
    name: "ProductMetaBoxes",
    components: {DialogCart, NoodleLoading, NoodleNumberControl},
    props: {
        product: {
            type: Object,
            default: () => {
                return {
                    variation_list: [],
                    additional_options: [],
                    meta_data: {},
                    metas: []
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
            loading: false,
            options: {},
            additional_options: [],
            usePointPurchase: false,
        }
    },
    computed: {
        finalPrice() {
            let options = {}, additional_options = [];
            let price = parseFloat(this.product.price);
            if (Array.isArray(this.product.variation_list)) {
                this.product.variation_list.map((item) => {
                    item.options.map((option) => {
                        if (option.selected) {
                            options[item.name] = option.title;
                            if (/\d+/.test(option.price)) {
                                price += parseFloat(option.price);
                            }
                        }
                    });
                });
            }

            if (Array.isArray(this.product.additional_options)) {
                this.product.additional_options.map((option) => {
                    if (option.selected) {
                        additional_options.push(option.title);
                        if (/\d+/.test(option.price)) {
                            price += parseFloat(option.price);
                        }
                    }
                });
            }

            this.options = options;
            this.additional_options = additional_options;

            return price.toFixed(2);
        },
        totalPoints() {
            return parseInt(this.product.point_price) * this.quantity;
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
            let {options, additional_options, usePointPurchase} = this;
            let purchase_via = usePointPurchase ? 'point' : 'order';
            HttpClient.post('/carts', {
                product_id: this.product.id,
                quantity: this.quantity,
                meta_data: {
                    options,
                    additional_options,
                    purchase_via,
                },
                purchase_via
            }).then((res) => {
                window.dispatchEvent(new Event('cartChanged'));
                window.dispatchEvent(new Event('pointChanged'));
                this.$showToast('Added to cart successfully!');
                this.$emit('added');
            }).catch(reason => {
                console.log(reason);
            }).finally(() => {

            });
        },
    },
    mounted() {

    }
}
</script>

<style scoped>

</style>