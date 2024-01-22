const TokenKey = 'admintoken';

export default {
    updateToken(token) {
        return localStorage.setItem(TokenKey, token);
    },
    getToken() {
        return localStorage.getItem(TokenKey);
    },
    removeToken() {
        return localStorage.removeItem(TokenKey);
    }
}
