import ApiService from "./ApiService";

const PostService = {
    list(params) {
        return ApiService.get('/posts', {params});
    },
    get(id) {
        return ApiService.get('/posts/' + id);
    },
    store(post) {
        return ApiService.post('/posts', {post});
    },
    update(id, post) {
        return ApiService.put('/posts/' + id, {post});
    },
    batchDelete(ids) {
        return ApiService.delete('posts/batch', {data:{ids}});
    },
    batchUpdate(ids, data) {
        return ApiService.put('/posts/batch', {ids, data});
    }
}

export default PostService;