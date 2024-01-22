import ApiService from "./ApiService";

const ProductService = {
    listProducts(params) {
        return ApiService.get('/products', {params});
    },
    getProduct(id) {
        return ApiService.get('/products/' + id);
    },
    storeProduct(product) {
        return ApiService.post('/products', {product});
    },
    updateProduct(id, product) {
        return ApiService.put('/products/' + id, {product});
    },
    deleteProducts(ids) {
        return ApiService.post('/products/batch-delete', {ids});
    },
    batchUpdate(ids, data) {
        return ApiService.post('/products/batch-update', {ids, data});
    }
}

export default ProductService;