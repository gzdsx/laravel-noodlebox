import ApiService from "./ApiService";

const ShopService = {
    listShops(params) {
        return ApiService.get('/shops', {params});
    },
    getShop(shop_id) {
        return ApiService.get('/shops/' + shop_id);
    },
    storeShop(shop) {
        return ApiService.post('/shops', {shop});
    },
    deleteShops(ids) {
        return ApiService.post('/shops/batch-delete', {ids});
    },
    updateShop(id, shop) {
        return ApiService.put('/shops/' + id, {shop});
    },
    verify(id, auth_state) {
        return ApiService.post('/shops/' + id + '/verify', {auth_state});
    },
    batchUpdate(ids, data) {
        return ApiService.post('/shops/batch-update', {ids, data});
    }
}

export default ShopService;