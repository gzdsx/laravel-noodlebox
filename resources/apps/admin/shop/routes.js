import ShopList from "./ShopList";
import ShopEdit from "./ShopEdit";


module.exports = [
    {path: '/shop/list', component: ShopList, meta: {title: '门店管理'}},
    {path: '/shop/new', component: ShopEdit, meta: {title: '新增门店'}},
    {path: '/shop/edit/:id?', component: ShopEdit, meta: {title: '编辑门店'}},
]
