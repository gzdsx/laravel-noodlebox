import Main from "./components/Main";
import Index from "./index/Index";
import UserInfo from "./user/UserInfo";
import Security from "./user/Security";
import AddressList from "./address/AddressList";
import PostCollect from "./collect/PostCollect";
import ProductCollect from "./collect/ProductCollect";
import OrderList from "./order/OrderList.vue";
import OrderDetail from "./order/OrderDetail.vue";
import OrderRate from "./order/OrderRate.vue";
import RefundApply from "./refund/RefundApply";
import RefundDetail from "./refund/RefundDetail";
import Bill from "./user/Bill";

const router = new VueRouter({
    routes: [
        {path: '/', component: Index, meta: {title: '用户中心'}},
        {path: '/userinfo', component: UserInfo, meta: {title: '资料设置'}},
        {path: '/security', component: Security, meta: {title: '账号安全'}},
        {path: '/address', component: AddressList, meta: {title: '收货地址'}},
        {path: '/bill', component: Bill, meta: {title: '我的账单'}},
        {path: '/collect', component: PostCollect, meta: {title: '我的收藏'}},
        {path: '/collect/post', component: PostCollect, meta: {title: '我的收藏'}},
        {path: '/collect/product', component: ProductCollect, meta: {title: '我的收藏'}},
        {path: '/orders', component: OrderList, meta: {title: '我的订单'}},
        {path: '/orders/:order_id', component: OrderDetail, meta: {title: '订单详情'}},
        {path: '/orders/rate', component: OrderRate, meta: {title: '订单评价'}},
        {path: '/refund/apply', component: RefundApply, meta: {title: '申请退款'}},
        {path: '/refund/detail', component: RefundDetail, meta: {title: '退款详情'}},
    ]
});

router.beforeEach((to, from, next) => {
    if (to.meta.title) {
        document.title = to.meta.title;
    }
    next();
});

const store = require('./vuex/store');

new Vue({
    router,
    store,
    render(h) {
        return h(Main)
    }
}).$mount('#app');
