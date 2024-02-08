import ProductList from "./ProductList";
import ProductEdit from "./ProductEdit";
import FreightTemplateList from "./FreightTemplateList";
import FreightTemplateEdit from "./FreightTemplateEdit";
import RefundAddress from "./RefundAddress";
import RefundReason from "./RefundReason";
import Coupon from "./Coupon";
import AttributeList from "./AttributeList.vue";
import VariationList from "./VariationList.vue";


module.exports = [
    {path: '/product/list', component: ProductList, meta: {title: '商品管理'}},
    {path: '/product/new', component: ProductEdit, meta: {title: '添加商品'}},
    {path: '/product/edit/:id?', component: ProductEdit, meta: {title: '编辑商品'}},
    {path: '/product/attributes', component: AttributeList, meta: {title: '产品型号'}},
    {path: '/product/variations', component: VariationList, meta: {title: '产品变量'}},
    {path: '/freight-template/list', component: FreightTemplateList, meta: {title: '运费模板'}},
    {path: '/freight-template/edit/:template_id?', component: FreightTemplateEdit, meta: {title: '编辑模板'}},
    {path: '/refund/address', component: RefundAddress, meta: {title: '退货地址'}},
    {path: '/refund/reason', component: RefundReason, meta: {title: '退货理由'}},
    {path: '/coupon/list', component: Coupon, meta: {title: '优惠券管理'}},
]
