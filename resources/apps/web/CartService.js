export default class CartService {
    constructor() {
        this.cartItems = this.getCartItems();
    }

    addToCart(product, price, quantity, options = {}, addtional_options = []) {
        this.cartItems.push({
            product_id: product.id,
            title: product.title,
            image: product.image,
            price: price,
            quantity: quantity,
            options: options,
            addtional_options: addtional_options
        });
        this.updateStorage();
    }

    removeFromCart(id) {
        this.cartItems = this.cartItems.filter(item => item.product_id !== id);
        this.updateStorage();
    }

    getCartItems() {
        try {
            let cartItems = JSON.parse(localStorage.getItem('cartItems'));
            if (Array.isArray(cartItems)) {
                cartItems.forEach(item => {
                    Object.defineProperty(item, 'subtotal', {
                        get() {
                            return (Number(this.price) * Number(this.quantity)).toFixed(2);
                        }
                    })
                });

                return cartItems;
            }
        } catch (e) {
            return [];
        }
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
    }
}