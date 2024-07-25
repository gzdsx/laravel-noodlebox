import ProductList from "./ProductList";
import ProductEdit from "./ProductEdit";
import FreightTemplateList from "./FreightTemplateList";
import FreightTemplateEdit from "./FreightTemplateEdit";
import RefundAddress from "./RefundAddress";
import RefundReason from "./RefundReason";
import Coupon from "./Coupon";
import AttributeList from "./AttributeList.vue";
import VariationList from "./VariationList.vue";
import ShippingZoneList from "./ShippingZoneList.vue";
import ShopList from "./ShopList.vue";
import ShopEdit from "./ShopEdit.vue";
import PhotoWall from "./PhotoWall.vue";
import DeliveryerList from "./DeliveryerList.vue";
import OrderList from "./OrderList.vue";
import OrderDetail from "./OrderDetail.vue";
import PosMachineList from "./PosMachineList.vue";
import Settings from "./Settings.vue";
import CashierTransaction from "./CashierTransaction.vue";
import DeliveryerTransaction from "./DeliveryerTransaction.vue";
import DeliveryerBilling from "./DeliveryerBilling.vue";
import CashierBilling from "./CashierBilling.vue";

module.exports = [
    {
        path: '/product/list',
        component: ProductList,
        meta: {title: '商品管理', capabilities: ['manager']}
    },
    {
        path: '/product/new',
        component: ProductEdit,
        meta: {title: '添加商品', capabilities: ['manager']}
    },
    {
        path: '/product/edit/:id?',
        component: ProductEdit,
        meta: {title: '编辑商品', capabilities: ['manager']}
    },
    {
        path: '/product/attributes',
        component: AttributeList,
        meta: {title: '产品型号', capabilities: ['manager']}
    },
    {
        path: '/product/variations',
        component: VariationList,
        meta: {title: '产品变量', capabilities: ['manager']}
    },
    {
        path: '/refund/address',
        component: RefundAddress,
        meta: {title: '退货地址', capabilities: ['manager']}
    },
    {
        path: '/refund/reason',
        component: RefundReason,
        meta: {title: '退货理由', capabilities: ['manager']}
    },
    {
        path: '/coupon/list',
        component: Coupon,
        meta: {title: '优惠券管理', capabilities: ['manager']}
    },
    {
        path: '/product/attributes',
        component: AttributeList,
        meta: {title: '产品型号', capabilities: ['manager']}
    },
    {
        path: '/product/variations',
        component: VariationList,
        meta: {title: '产品变量', capabilities: ['manager']}
    },
    // {
    //     path: '/freight-template/list',
    //     component: FreightTemplateList,
    //     meta: {title: '运费模板', capabilities: ['administrator', 'manager']}
    // },
    // {
    //     path: '/freight-template/edit/:id?',
    //     component: FreightTemplateEdit,
    //     meta: {title: '编辑模板', capabilities: ['administrator', 'manager']}
    // },
    {
        path: '/shipping-zone/list',
        component: ShippingZoneList,
        meta: {title: '配送区域', capabilities: []}
    },
    {
        path: '/shop/list',
        component: ShopList,
        meta: {title: '门店管理', capabilities: []}
    },
    {
        path: '/shop/new',
        component: ShopEdit,
        meta: {title: '新增门店', capabilities: ['manager']}
    },
    {
        path: '/shop/edit/:id?',
        component: ShopEdit,
        meta: {title: '编辑门店', capabilities: []}
    },
    {
        path: '/photo-wall',
        component: PhotoWall,
        meta: {title: '照片墙', capabilities: ['manager']}
    },
    {
        path: '/deliveryers',
        component: DeliveryerList,
        meta: {title: '配送员管理', capabilities: ['manager']}
    },
    {
        path: '/order/list',
        component: OrderList,
        meta: {title: '订单管理', capabilities: ['manager']}
    },
    {
        path: '/order/detail/:id?',
        component: OrderDetail,
        meta: {title: '订单详情', capabilities: ['manager']}
    },
    {
        path: '/pos-machines',
        component: PosMachineList,
        meta: {title: 'POS管理', capabilities: []}
    },
    {
        path: '/shop/settings',
        component: Settings,
        meta: {title: '店铺设置', capabilities: []}
    },
    {
        path: '/cashier/transactions',
        component: CashierTransaction,
        meta: {title: '收银台账', capabilities: ['manager']}
    },
    {
        path: '/cashier/billing',
        component: CashierBilling,
        meta: {title: '收银账单', capabilities: ['manager']}
    },
    {
        path: '/deliveryer/transactions',
        component: DeliveryerTransaction,
        meta: {title: '司机台账', capabilities: ['manager']}
    },
    {
        path: '/deliveryer/billing',
        component: DeliveryerBilling,
        meta: {title: '司机账单', capabilities: ['manager']}
    }
]
