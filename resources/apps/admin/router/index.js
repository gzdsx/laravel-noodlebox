import AdminIndex from "../index/AdminIndex";
const createRouter = () => new VueRouter({
    // mode: 'history', // require service support
    scrollBehavior: () => ({y: 0}),
    routes: [
        {
            path: '/',
            component: AdminIndex,
            meta: {title: '仪表板'}
        },
        {
            path: '*',
            component: () => require('../error/404')
        }
    ]
});

export function resetRouter() {
    const newRouter = createRouter()
    router.matcher = newRouter.matcher // reset router
}

const router = createRouter()
export default router