<template>
    <div class="product-metabox">
        <h3>{{ product.title }}</h3>
        <div class="product-potins">
            Noodle Box Earn Points : {{ product.points }} Points
        </div>
        <div class="product-price text-bull-cyan">€{{ finalPrice }}</div>
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
import NoodleNumberControl from "./NoodleNumberControl.vue";
import NoodleLoading from "./NoodleLoading.vue";
import DialogCart from "./DialogCart.vue";
import CartService from "../CartService";

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
            loading: false,
            options: {},
            additional_options: []
        }
    },
    computed: {
        finalPrice() {
            let options = {}, additional_options = [];
            let price = parseFloat(this.product.price);
            if (Array.isArray(this.product.variation_list)) {
                this.product.variation_list.map((item) => {
                    item.options.map((option) => {
                        if (option.selected && /\d+/.test(option.price)) {
                            price += parseFloat(option.price);
                            options[item.name] = option.title;
                        }
                    });
                });
            }

            if (Array.isArray(this.product.additional_options)) {
                this.product.additional_options.map((option) => {
                    if (option.selected && /\d+/.test(option.price)) {
                        price += parseFloat(option.price);
                        additional_options.push(option.title);
                    }
                });
            }

            this.options = options;
            this.additional_options = additional_options;

            return price.toFixed(2);
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
            let {product, finalPrice, quantity, options, additional_options} = this;

            const cart = new CartService();
            cart.addToCart(
                product,
                finalPrice,
                quantity,
                options,
                additional_options
            );
            this.$showToast('Added to cart successfully!');
        }
    },
    mounted() {

    }
}
</script>

<style scoped>

</style>