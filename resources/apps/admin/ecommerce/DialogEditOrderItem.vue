<template>
    <el-dialog
            title="Edit Item"
            width="75%"
            :visible="value"
            :close-on-click-modal="false"
            :close-on-press-escape="false"
            append-to-body
            closeable
            @close="close"
    >
        <div class="dialog-product-metas">
            <div class="product-variations" v-for="(variation, index) in product.variation_list" :key="index">
                <h3>{{ variation.name }}</h3>
                <div class="product-variations__options">
                    <el-button
                            size="small"
                            :type="option.selected ? 'primary' : 'default'"
                            @click="handlerSelectOption(variation,option)"
                            v-for="(option, index) in variation.options"
                            :key="index">
                        {{ option.title }}
                    </el-button>
                </div>
            </div>
            <div>
                <h3>Quantity</h3>
                <el-input-number v-model="orderItem.quantity" size="small" :min="1" :max="10"/>
            </div>
            <div>
                <el-button size="medium" type="primary" @click="onSubmit">Save</el-button>
            </div>
        </div>
    </el-dialog>
</template>

<script>
import ApiService from "../utils/ApiService";

export default {
    name: "DialogEditOrderItem",
    props: {
        value: {
            type: Boolean,
            default: false
        },
        orderItem: {
            type: Object,
            default() {
                return {}
            }
        }
    },
    data() {
        return {
            loading: false,
            product: {
                variation_list: [],
                variation_options: []
            }
        }
    },
    watch: {
        value(val) {
            if (val) {
                this.fetchData();
            }
        }
    },
    methods: {
        close() {
            this.$emit('input', false);
        },
        fetchData() {
            this.loading = true;
            ApiService.get(`/products/${this.orderItem.product_id}`).then(response => {
                let {meta_data} = this.orderItem;
                if (Array.isArray(response.data.variation_list)) {
                    response.data.variation_list.forEach((item) => {
                        if (meta_data[item.name]) {
                            item.options.forEach((option) => {
                                option.selected = option.title === meta_data[item.name];
                            });
                        }
                    });
                }

                this.product = {
                    ...this.product,
                    ...response.data
                };
            }).finally(() => {
                this.loading = false;
            });
        },
        handlerSelectOption(v, o) {
            v.options.forEach((item) => {
                item.selected = item.title === o.title;
            });
        },
        onSubmit() {
            let meta_data = {};
            if (Array.isArray(this.product.variation_list)) {
                this.product.variation_list.forEach((item) => {
                    item.options.forEach((option) => {
                        if (option.selected) {
                            meta_data[item.name] = option.title;
                        }
                    });
                });
            }
            this.orderItem.meta_data = meta_data;
            this.$emit('update', this.orderItem);
        }
    }
}
</script>

<style scoped>

</style>