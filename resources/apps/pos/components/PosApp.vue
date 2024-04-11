<template>
    <div class="pos-body">
        <div class="pos-col pos-col-left">
            <div class="searchbar">
                <div class="col-logo">
                    <img src="/images/noodlebox/pos-logo.png" alt="">
                </div>
                <div class="col-input">
                    <auto-complete @select="addProduct"/>
                </div>
                <div class="col-calculator">
                    <div class="calculator" @click="showWellcome=true">
                        <i class="yith-pos-icon-customer"></i>
                    </div>
                </div>
            </div>
            <product-categories @select="addProduct" key="product-categories" v-if="tabIndex===0"/>
        </div>
        <div class="pos-col pos-cart">
            <div class="cart-items" ref="cartScroll" v-if="order.line_items.length">
                <div class="cart-item" v-for="(item,index) in order.line_items" :key="index">
                    <div class="cart-item__row">
                        <div class="cart-item__remove" @click="order.line_items.splice(index,1);$beep.play()">
                            <i class="yith-pos-icon-clear"></i>
                        </div>
                        <div class="cart-item__name" @click="editCartItem(item)">
                            <div class="cart-item__name__title">{{ item.name }}</div>
                            <div class="cart-item__name__variation" v-if="item.variation_name">{{
                                item.variation_name
                                }}
                            </div>
                            <div class="cart-item__name__comments">
                                <div class="cart-item__name__comment" v-for="(comment,j) in item.comments" :key="j">
                                    <div class="title">{{ comment.type|capitalize }}-{{ comment.name }}</div>
                                    <div class="price">€{{ $toAmount(comment.price) }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="cart-item__price" @click="editCartItem(item)">€{{ item.price }} x
                            {{ item.quantity }}
                        </div>
                        <div class="cart-item__total">€{{ $toAmount(item.subtotal) }}</div>
                    </div>
                </div>
            </div>
            <div class="cart-items empty-cart" ref="cartScroll" v-else>
                <div class="cart-empty-box">
                    <div class="cart-empty-svg"></div>
                    <span>Add the first product to the cart</span>
                </div>
            </div>

            <div class="cart-totals">
                <div class="cart-total cart-total-subtotal">
                    <div class="cart-total__label">Subtotal</div>
                    <div class="cart-total__price">€{{ $toAmount(order.subTotal) }}</div>
                </div>
                <div class="cart-total" v-for="(s,idx) in order.shipping_lines" :key="'s'+idx">
                    <div class="cart-total__label">Shipping - {{ s.method_title }}</div>
                    <div class="cart-total__price">€{{ $toAmount(s.total) }}</div>
                </div>
                <div class="cart-total" v-for="(f,idx) in order.fee_lines" :key="'f'+idx">
                    <div class="cart-total__remove" @click="order.fee_lines.splice(idx,1)">
                        <i class="yith-pos-icon-clear"></i>
                    </div>
                    <div class="cart-total__label">Fee - {{ f.name }}</div>
                    <div class="cart-total__price text-red">€{{ $toAmount(f.total) }}</div>
                </div>
                <div class="cart-total cart-total-total ">
                    <div class="cart-total__label">Total</div>
                    <div class="cart-total__price">€{{ $toAmount(order.total) }}</div>
                </div>
            </div>
            <div class="order-notes order-editable cursor-pointer" @click="showNote=true"
                 v-if="order.customer_note.length">
                <h5 class="text-uppercase">Note</h5>
                <p>{{ order.customer_note }}</p>
            </div>
            <div class="cart-empty-carts" v-if="order.line_items.length">
                <div class="cart-empty-carts__flex"></div>
                <div class="cart-empty-carts__btn" @click="emptyCart">&times; Empty Cart</div>
            </div>
            <div class="cart-actions">
                <div class="cart-action cart-action--add-note" @click="showNote=true">
                    <i class="yith-pos-icon-item-note"></i>
                    <span>Add Note</span>
                </div>
                <div class="cart-action" @click="showFee=true">
                    <i class="yith-pos-icon-add"></i>
                    <span>Add Fee</span>
                </div>
                <div class="cart-action" @click="showPassword=true">
                    <i class="yith-pos-icon-gift-card"></i>
                    <span>Add Discount</span>
                </div>
                <button class="cart-action" @click="showShippingAddress=true">
                    <i class="yith-pos-icon-shipping"></i>
                    <span>Shipping</span>
                </button>
                <button class="cart-action cart-action--pay" @click="showPayment=true">
                    <span>Pay</span>
                </button>
            </div>
        </div>

        <div class="cart-float">
            <div class="cart-float__btn" @click="prevPage">
                <i class="yith-pos-icon-arrow-left prev"></i>
            </div>

            <div class="cart-float__btn" @click="nextPage">
                <i class="yith-pos-icon-arrow-left next"></i>
            </div>
        </div>

        <dialog-payment
                :order.sync="order"
                @success="onOrderCreated"
                v-model="showPayment"
        />
        <dialog-order :order.sync="newOrder" @close="onCheckoutFinish" v-model="showOrder"/>
        <dialog-fee @submit="addFee" v-model="showFee"/>
        <dialog-note @submit="addNote" v-model="showNote"/>
        <dialog-product
                :default-line-item.sync="theLineItem"
                @submit="addCartItem"
                v-model="showProductInfo"
        />
        <dialog-discount @submit="addDiscount" v-model="showDiscount"/>
        <dialog-search-customer
                ref="scustomer"
                :shipping-method.sync="shipping_method"
                @select="selectCustomer"
                @create="createCustomer"
                @change="onInputCustomerPhone"
                v-model="showSearchCustomer"
        />
        <dialog-create-customer
                :customer.sync="theCustomer"
                :shipping-method.sync="shipping_method"
                @update="selectCustomer"
                v-model="showCreateCustomer"
        />
        <dialog-customer-info
                @edit="editCustomer"
                @submit="addCustomer"
                :customer="theCustomer"
                v-model="showCustomerInfo"
        />
        <dialog-wellcome @select="selectAct" v-model="showWellcome"/>
        <dialog-shipping-address
                :method.sync="shipping_method"
                :shipping.sync="customer.billing"
                @submit="onShippingChange"
                v-model="showShippingAddress"
        />
        <pos-loading v-model="showLoading"/>
        <dialog-password
                @close="showPassword=false"
                @logined="showPassword=false;showDiscount=true"
                v-if="showPassword"
        />
    </div>
</template>

<script>
import NumberControl from "./NumberControl.vue";
import AutoComplete from "./AutoComplete.vue";
import DialogPayment from "./DialogPayment.vue";
import DialogOrder from "./DialogOrder.vue";
import DialogShipping from "./DialogShipping.vue";
import DialogFee from "./DialogFee.vue";
import DialogNote from "./DialogNote.vue";
import DialogCustomerInfo from "./DialogCustomerInfo.vue";
import ProductList from "./ProductList.vue";
import ProductCategories from "./ProductCategories.vue";
import DialogProduct from "./DialogProduct.vue";
import DialogDiscount from "./DialogDiscount.vue";
import DialogSearchCustomer from "./DialogSearchCustomer.vue";
import DialogCreateCustomer from "./DialogCreateCustomer.vue";
import DialogWellcome from "./DialogWellcome.vue";
import DialogShippingAddress from "./DialogShippingAddress.vue";
import BuildLineItem from "../BuildLineItem";
import DialogPassword from "./DialogPassword.vue";

export default {
    name: "PosApp",
    components: {
        DialogPassword,
        DialogShippingAddress,
        DialogWellcome,
        DialogCreateCustomer,
        DialogSearchCustomer,
        DialogCustomerInfo,
        DialogDiscount,
        DialogProduct,
        ProductCategories,
        ProductList,
        DialogNote,
        DialogFee,
        DialogShipping,
        DialogOrder,
        DialogPayment,
        AutoComplete,
        NumberControl,
    },
    data() {
        return {
            tabs: [],
            tabIndex: 0,
            categories: [],
            loading: true,
            loadingMore: true,
            order: {},
            newOrder: {},
            customer: {},
            theCustomer: {
                billing: {city: 'Drogheda', country: 'Ireland'},
                shipping: {city: 'Drogheda', country: 'Ireland'}
            },
            theLineItem: {},
            discount: {},
            showSearchCustomer: false,
            showCreateCustomer: false,
            showShippingAddress: false,
            showPayment: false,
            showLoading: false,
            showOrder: false,
            showShipping: false,
            showFee: false,
            showNote: false,
            showCustomerDropdown: false,
            showCustomerInfo: false,
            showProductInfo: false,
            showDiscount: false,
            showWellcome: false,
            shipping_method: 'local_pickup',
            shipping_line: {},
            addCartItem: function (item) {

            },
            showPassword: false
        }
    },
    computed: {
        disbaled() {
            return this.order.line_items.length === 0;
        }
    },
    watch: {
        customer(val) {
            this.$store.commit('setCustomer', val);
        }
    },
    methods: {
        addProduct(p) {
            const item = BuildLineItem(p);
            this.addCartItem = (newitem) => {
                this.$beep.play();
                this.order.line_items.push(newitem);
                this.scrollToBottom();
            }
            if (item.attributes.length > 0) {
                this.theLineItem = item;
                this.showProductInfo = true;
            } else {
                this.addCartItem(item);
            }
        },
        editCartItem(item) {
            this.theLineItem = item;
            this.showProductInfo = true;
            this.addCartItem = (newitem) => {
                this.$beep.play();
                this.theLineItem = newitem;
            }
        },
        addCustomer(c) {
            this.customer = c;
            this.order.customer_id = c.id;
            this.order.billing = c.billing;
            this.order.shipping = c.billing;
            this.showSearchCustomer = false;
        },
        removeCustomer() {
            this.customer = {};
            this.order.customer_id = 0;
            this.order.billing = {};
            this.order.shipping = {};
        },
        selectCustomer(c) {
            this.customer = c;
            this.theCustomer = {
                billing: {city: 'Drogheda'},
                shipping: {city: 'Drogheda'}
            };
            this.showShippingAddress = true;
        },
        createCustomer() {
            this.showSearchCustomer = false;
            this.showCreateCustomer = true;
            this.$forceUpdate();
        },
        editCustomer(c) {
            this.theCustomer = c;
            this.showCustomerInfo = false;
            this.showCreateCustomer = true;
        },
        onInputCustomerPhone(v) {
            this.theCustomer.billing.phone = v;
            this.theCustomer.shipping.phone = v;
            if (this.theCustomer.billing.first_name) {
                this.theCustomer.billing.first_name = 'customer_' + v;
                this.theCustomer.shipping.first_name = 'customer_' + v;
            }
        },
        selectAct(v) {
            this.shipping_method = v;
            if (v === 'local_pickup') {
                this.showSearchCustomer = true;
            }

            if (v === 'flat_rate') {
                this.showSearchCustomer = true;
            }

            if (v === 'guest') {

            }
        },
        onShippingChange(v) {
            const {shipping, shipping_line} = v;
            this.order.billing = shipping;
            this.order.shipping = shipping;
            this.order.shipping_lines = [shipping_line];
            this.customer.shipping = shipping;
            this.customer.billing = shipping;

            if (!this.customer.id) {
                let customer = this;
                customer.first_name = shipping.first_name;
                customer.email = shipping.email;
                customer.password = '123456';
                this.showLoading = true;
                this.$http.post('cusotmers', {customer}).then(resp => {
                    this.customer = resp;
                    this.order.customer_id = resp.id;
                    this.$forceUpdate();
                }).finally(() => {
                    this.showLoading = false;
                });
            }
            //console.log(this.order);
        },
        addFee(f) {
            this.order.fee_lines.push(f);
        },
        addNote(c) {
            this.order.customer_note = c;
        },
        addDiscount(d) {
            const {code, description} = d;
            this.order.coupon_lines.push({code});
        },
        onOrderCreated(newOrder) {
            this.newOrder = newOrder;
            this.showOrder = true;
            this.resetCart();
            this.$refs.scustomer.reset();
        },
        onCheckoutFinish() {
            this.$router.history.go(0);
        },
        emptyCart() {
            this.order.line_items = [];
        },
        printOrder() {
            const iframe = document.createElement('iframe');
            const f = document.body.appendChild(iframe);
            const w = f.contentWindow || f.contentDocument;
            const d = f.contentDocument || f.contentWindow.document;

            d.body.innerHTML = 'Content';
            w.print();
            document.body.removeChild(iframe);
        },
        resetCart() {
            this.order = {
                customer_id: 0,
                customer_note: '',
                payment_method: "yith_pos_cash_gateway",
                payment_method_title: "Cash",
                set_paid: true,
                line_items: [],
                billing: {},
                shipping: {},
                shipping_lines: [],
                fee_lines: [],
                coupon_lines: [],
                meta_data: [
                    {
                        key: '_ywsn_receive_sms',
                        value: 'yes'
                    },
                    {
                        key: '_yith_booking_request_confirmation',
                        value: 'yes'
                    }
                ]
            };
        },
        selectComments(v) {
            this.theLineItem.comments = v;
        },
        prevPage() {
            this.$refs.cartScroll.scrollTop -= 100;
        },
        nextPage() {
            this.$refs.cartScroll.scrollTop += 100;
        },
        scrollToBottom() {
            this.$nextTick(() => {
                this.$refs.cartScroll.scrollTop = this.$refs.cartScroll.scrollHeight;
            });
        }
    },
    created() {
        this.resetCart();
        if (this.order) {
            Object.defineProperty(this.order, 'total', {
                get() {
                    let total = this.line_items.reduce((a, b) => {
                        return a + parseFloat(b.total);
                    }, 0);

                    total += this.fee_lines.reduce((a, b) => {
                        return a + parseFloat(b.total);
                    }, 0);

                    total += this.shipping_lines.reduce((a, b) => {
                        return a + parseFloat(b.total);
                    }, 0);

                    return total;
                },
            });

            Object.defineProperty(this.order, 'subTotal', {
                get() {
                    return this.line_items.reduce((a, b) => {
                        return a + parseFloat(b.subtotal);
                    }, 0);
                }
            });
        }
    },
    mounted() {
    }
}
</script>

<style scoped>

</style>