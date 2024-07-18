import ApiService from "./ApiService";

const ShopService = {
    listShops(params) {
        return ApiService.get('/shops', {params});
    },
    getShop(id) {
        return ApiService.get('/shops/' + id);
    },
    storeShop(shop) {
        return ApiService.post('/shops', shop);
    },
    deleteShops(ids) {
        return ApiService.delete('/shops/batch', {data: {ids}});
    },
    updateShop(id, shop) {
        return ApiService.put('/shops/' + id, shop);
    },
    verify(id, varify_status) {
        return ApiService.post('/shops/' + id + '/verify', {varify_status});
    },
    batchUpdate(ids, data) {
        return ApiService.put('/shops/batch', {ids, data});
    }
}

export default ShopService;