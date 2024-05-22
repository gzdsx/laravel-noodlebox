import AdminIndex from "./index/AdminIndex";
import Login from "./auth/Login.vue";

const router = new VueRouter({
    routes: [
        {path: '/', component: AdminIndex, meta: {title: '仪表板', group: 'home'}},
        {path: '/login', component: Login, name: 'login', meta: {title: '登录'}},
    ]
});

const SettingRoutes = require('./setting/routes');
router.addRoutes(SettingRoutes);

const UserRoutes = require('./user/routes');
router.addRoutes(UserRoutes);

const BasicRoutes = require('./basic/routes');
router.addRoutes(BasicRoutes);

const WechatRoutes = require('./wechat/routes');
router.addRoutes(WechatRoutes);

const PageRoutes = require('./page/routes');
router.addRoutes(PageRoutes);

const PostRoutes = require('./post/routes');
router.addRoutes(PostRoutes);

const EcommerceRoutes = require('./ecommerce/routes');
router.addRoutes(EcommerceRoutes);

const TradeRoutes = require('./trade/routes');
router.addRoutes(TradeRoutes);

const LotteryRoutes = require('./lottery/routes');
router.addRoutes(LotteryRoutes);

router.addRoutes([
    {
        path: '*',
        component: () => require('./error/404')
    }
]);

module.exports = router;
