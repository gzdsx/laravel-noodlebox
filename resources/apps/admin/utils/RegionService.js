import ApiService from "./ApiService";

export default {
    list(params){
        return ApiService.get('/regions',{params});
    },
}