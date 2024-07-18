import ApiService from "./ApiService";

const PostService = {
    list(params) {
        return ApiService.get('/posts', {params});
    },
    get(id) {
        return ApiService.get('/posts/' + id);
    },
    store(data) {
        return ApiService.post('/posts', data);
    },
    update(id, data) {
        return ApiService.put('/posts/' + id, data);
    },
    batchDelete(ids) {
        return ApiService.delete('posts/batch', {data:{ids}});
    },
    batchUpdate(ids, data) {
        return ApiService.put('/posts/batch', {ids, data});
    }
}

export default PostService;