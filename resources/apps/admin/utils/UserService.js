import ApiService from "./ApiService";

const UserService = {
    listUsers(params) {
        return ApiService.get('/users', {params});
    },
    getUser(uid) {
        return ApiService.get('/users/' + uid);
    },
    storeUser(user) {
        return ApiService.post('/users', {user});
    },
    updateUser(uid, user) {
        return ApiService.put('/users/' + uid, {user});
    },
    deleteUser(ids) {
        return ApiService.delete('/users/batch', {data: {ids}});
    },
    batchUpdate(ids, data) {
        return ApiService.put('/users/batch', {ids, data});
    },
    listGroups(params) {
        return ApiService.get('/user-groups', {params});
    },
    getGroup(gid) {
        return ApiService.get('/user-groups/' + gid);
    },
    storeGroup(group) {
        return ApiService.post('/user-groups', {group});
    },
    updateGroup(gid, group) {
        return ApiService.put('/user-groups/' + gid, {group});
    },
    deleteGroup(ids) {
        return ApiService.delete('/user-groups/batch', {data: {ids}});
    }
}

export default UserService;