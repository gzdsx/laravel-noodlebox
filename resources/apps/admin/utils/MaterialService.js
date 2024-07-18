import ApiService from "./ApiService";

const MaterialService = {
    list(params) {
        return ApiService.get('/materials', {params});
    },
    get(id) {
        return ApiService.get('/materials/' + id);
    },
    update(id, data) {
        return ApiService.put('/materials/' + id, data);
    },
    batchDelete(ids) {
        return ApiService.delete('/materials/batch', {data: {ids}});
    }
}

export default MaterialService;