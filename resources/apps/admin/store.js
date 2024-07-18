import Vuex from 'vuex';

const store = new Vuex.Store({
    state: {
        isSignined: false,
        userInfo: {}
    },
    mutations: {
        signin(state, userInfo) {
            state.userInfo = userInfo;
            state.isSignined = true;
        },
        signout(state) {
            state.userInfo = {};
            state.isSignined = true;
        }
    },
    actions: {
        signin(context, userInfo) {
            context.commit('signin', userInfo);
        },
        signout(context) {
            context.commit('signout');
        }
    },
    getters: {
        isSignined: state => state.isSignined,
        userInfo: state => state.userInfo
    }
});

module.exports = store;
