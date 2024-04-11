<template>
    <pos-dialog :title="dialogTitle" :visible="value" @close="close">
        <div class="pos-customer-search">
            <pos-input
                    type="text"
                    placeholder="Please enter customer's phone number"
                    @input="handleInput"
                    v-model="search"
            >
                <i class="yith-pos-icon-search text-secondary" slot="append"></i>
            </pos-input>
        </div>
        <div class="pos-customer-list">
            <div class="text-center" v-if="loading">
                <i class="gzdsx-pos-spinner"></i>
            </div>
            <div class="pos-empty" v-if="customers.length===0 && !loading">
                <span>No results found.</span>
            </div>
            <div class="pos-customer-list-item" v-for="(item,index) in customers" :key="index"
                 @click="handleSelect(item)">
                <div>
                    <img :src="$imageSrc(item.avatar_url)" class="pos-customer-list-item__image" alt="">
                </div>
                <div class="pos-customer-list-item__name">
                    <div class="name">{{ item.billing.first_name }}({{ item.billing.phone }})</div>
                    <div class="address">
                        {{ item.billing.address_1 }},
                        {{ item.billing.city }},
                        {{ item.billing.state }},
                        {{ item.billing.country }}
                    </div>
                </div>
            </div>
        </div>
        <div class="gzdsx-pos-dialog__footer" slot="footer">
            <button class="btn btn-primary" @click="handleCreate">Create a new customer</button>
            <button class="btn btn-warning" @click="close">Proceed as guest</button>
        </div>
    </pos-dialog>
</template>

<script>
let controller = new AbortController();
export default {
    name: "DialogSearchCustomer",
    props: {
        value: Boolean,
        shippingMethod:{
            type:String,
            default: 'local_pickup'
        }
    },
    watch: {
        shippingMethod(val) {
            this.setDialogtitle();
        }
    },
    data() {
        return {
            loading: false,
            customers: [],
            search: '',
            dialogTitle:''
        }
    },
    methods: {
        close() {
            this.$emit('input', false);
        },
        handleInput(v) {
            if (v.length < 2) {
                this.customers = [];
                return;
            }

            if (controller) {
                controller.abort();
                controller = new AbortController();
            }

            this.searchCustomers();
            this.$emit('change', v);
        },
        handleSelect(item) {
            this.$emit('select', item);
            this.close();
        },
        handleCreate() {
            this.$emit('create')
        },
        searchCustomers() {
            this.loading = true;
            this.$http.get('customers',
                {
                    params: {
                        phone: this.search,
                        per_page: 20,
                        orderby: 'registered_date',
                        order: 'desc'
                    },
                    signal: controller.signal
                }
            ).then(response => {
                this.customers = response;
            }).catch(() => {

            }).finally(() => {
                this.loading = false;
            });
        },
        reset(){
            this.search = '';
            this.customers = [];
        },
        setDialogtitle(){
            if (this.shippingMethod === 'local_pickup'){
                this.dialogTitle = 'Load a customer profile - Collection';
            }else {
                this.dialogTitle = 'Load a customer profile - Delivery';
            }
        }
    },
    mounted() {
        //this.searchCustomers();
        this.setDialogtitle();
    }
}
</script>

<style scoped>

</style>