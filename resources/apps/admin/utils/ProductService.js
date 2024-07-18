import ApiService from "./ApiService";

const ProductService = {
    listProducts(params) {
        return ApiService.get('/products', {params});
    },
    getProduct(id) {
        return ApiService.get('/products/' + id);
    },
    storeProduct(data) {
        return ApiService.post('/products', data);
    },
    updateProduct(id, data) {
        return ApiService.put('/products/' + id, data);
    },
    deleteProducts(ids) {
        return ApiService.delete('/products/batch', {data: {ids}});
    },
    batchUpdate(ids, data) {
        return ApiService.post('/products/batch', {ids, data});
    },
    batchAdjust(ids, action) {
        return ApiService.post('/products/adjust', {ids, action});
    }
}

export default ProductService;