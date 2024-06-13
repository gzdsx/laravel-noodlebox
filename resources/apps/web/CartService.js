import {md5} from "js-md5";

export default class CartService {
    constructor() {
        this.cartItems = [];
        try {
            let cartItems = JSON.parse(localStorage.getItem('cartItems'));
            if (Array.isArray(cartItems)) {
                cartItems.forEach(item => {
                    Object.defineProperty(item, 'subtotal', {
                        get() {
                            if (item.usePointPurchase) {
                                return 0;
                            }
                            return (Number(this.price) * Number(this.quantity)).toFixed(2);
                        }
                    });

                    Object.defineProperty(item, 'pointTotal', {
                        get() {
                            if (item.usePointPurchase) {
                                return (Number(this.point_price) * Number(this.quantity)).toFixed(2);
                            }
                            return 0;
                        }
                    });
                });

                this.cartItems = cartItems;
            }
        } catch (e) {

        }
    }

    addToCart(cart_item) {
        let {product_id, options, additional_options, quantity, usePointPurchase} = cart_item;
        let key = md5(product_id + JSON.stringify(options) + JSON.stringify(additional_options) + usePointPurchase.toString());
        let index = this.cartItems.findIndex(item => item.key === key);
        if (index !== -1) {
            this.cartItems[index].quantity += quantity;
        } else {
            this.cartItems.push({
                key: key,
                ...cart_item
            });
        }
        this.updateStorage();
    }

    removeFromCart(id) {
        this.cartItems = this.cartItems.filter(item => item.product_id !== id);
        this.updateStorage();
    }

    getCartItems() {
        return this.cartItems;
    }

    saveItems(items) {
        this.cartItems = items;
        this.updateStorage();
    }

    clearCart() {
        this.cartItems = [];
        this.updateStorage();
    }

    updateStorage() {
        localStorage.setItem('cartItems', JSON.stringify(this.cartItems));
        let event = new Event('cartChanged');
        event.count = this.cartItems.length;
        window.dispatchEvent(event);
    }

    getCount() {
        return this.cartItems.length;
    }
}