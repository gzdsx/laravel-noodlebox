import ApiService from "./ApiService";

const CategoryService = {
    list(params) {
        return ApiService.get('/categories', {params});
    },
    get(id) {
        return ApiService.get('/categories/' + id);
    },
    store(category) {
        return ApiService.post('/categories', {category});
    },
    update(id, category) {
        return ApiService.put('/categories/' + id, {category});
    },
    increase(id) {
        return ApiService.post('/categories' + id + '/increase');
    },
    decrease(id) {
        return ApiService.post('/categories/' + id + '/decrease');
    },
    batchDelete(ids) {
        return ApiService.delete('/categories/batch', {data: {ids}});
    },
    generateCascaderOptions(categories) {
        function t(a) {
            return a.map(function (c) {
                var obj = {
                    value: c.id,
                    label: c.name,
                };
                if (c.children.length > 0) {
                    obj.children = t(c.children);
                }
                return obj;
            });
        }

        return t(categories);
    }
};


export default CategoryService;