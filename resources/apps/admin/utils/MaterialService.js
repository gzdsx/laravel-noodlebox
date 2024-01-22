import ApiService from "./ApiService";

const MaterialService = {
    list(params) {
        return ApiService.get('/materials', {params});
    },
    get(id) {
        return ApiService.get('/materials/' + id);
    },
    update(id, material) {
        return ApiService.put('/materials/' + id, {material});
    },
    batchDelete(ids) {
        return ApiService.delete('/materials/batch', {data: {ids}});
    }
}

export default MaterialService;