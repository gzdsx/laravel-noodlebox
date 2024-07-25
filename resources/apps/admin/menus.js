export default [
    {
        name: 'sidebar.dashboard',
        icon: 'speedometer',
        capabilities: ['manager'],
        children: [
            {
                name: 'sidebar.dashboard',
                path: '/',
                capabilities: ['manager'],
            }
        ]
    },
    {
        name: 'sidebar.settings',
        icon: 'gear-wide',
        capabilities: [],
        children: [
            {
                name: 'sidebar.settings_general',
                path: '/settings/general',
                capabilities: [],
            },
            {
                name: 'sidebar.settings_register',
                path: '/settings/register',
                capabilities: [],
            },
            {
                name: 'sidebar.settings_attach',
                path: '/settings/attach',
                capabilities: [],
            },
            {
                name: 'sidebar.settings_watermark',
                path: '/settings/water',
                capabilities: [],
            },
            {
                name: 'sidebar.settings_mail',
                path: '/settings/mail',
                capabilities: [],
            },
            {
                name: 'sidebar.settings_theme',
                path: '/settings/theme',
                capabilities: [],
            },
        ]
    },
    {
        name: 'sidebar.users',
        icon: 'people',
        capabilities: [],
        children: [
            {
                name: 'sidebar.user_add',
                path: '/user/new',
                capabilities: [],
            },
            {
                name: 'sidebar.user_manage',
                path: '/user/list',
                capabilities: [],
            },
        ]
    },
    {
        name: 'sidebar.pages',
        icon: 'box',
        capabilities: [],
        children: [
            {
                name: 'sidebar.page_addnew',
                path: '/page/new',
                capabilities: [],
            },
            {
                name: 'sidebar.page_manage',
                path: '/page/list',
                capabilities: [],
            }
        ]
    },
    {
        name: 'sidebar.posts',
        icon: 'pencil-square',
        capabilities: ['manager'],
        children: [
            {
                name: 'sidebar.post_addnew',
                path: '/post/new',
                capabilities: ['manager'],
            },
            {
                name: 'sidebar.post_manage',
                path: '/post/list',
                capabilities: ['manager'],
            },
            {
                name: 'sidebar.post_category',
                path: '/category',
                capabilities: [],
            }
        ]
    },
    {
        name: 'sidebar.shop',
        icon: 'bag',
        capabilities: ['manager'],
        children: [
            {
                name: 'shop.settings',
                path: '/shop/settings',
                capabilities: [],
            },
            {
                name: 'shop.add_product',
                path: '/product/new',
                capabilities: ['manager'],
            },
            {
                name: 'shop.product_list',
                path: '/product/list',
                capabilities: ['manager'],
            },
            {
                name: 'shop.product_category',
                path: '/category/product',
                capabilities: [],
            },
            {
                name: 'shop.variations',
                path: '/product/variations',
                capabilities: [],
            },
            {
                name: 'shop.orders',
                path: '/order/list',
                capabilities: ['manager'],
            },
            {
                name: 'shop.shops',
                path: '/shop/list',
                capabilities: [],
            },
            {
                name: 'shop.shipping_zones',
                path: '/shipping-zone/list',
                capabilities: [],
            },
            {
                name: 'shop.deliveryers',
                path: '/deliveryers',
                capabilities: ['manager'],
            },
            {
                name: 'shop.pos_machines',
                path: '/pos-machines',
                capabilities: [],
            },
            {
                name: 'shop.cashier_report',
                path: '/cashier/billing',
                capabilities: ['manager'],
            },
            {
                name: 'shop.deliveryer_report',
                path: '/deliveryer/billing',
                capabilities: ['manager'],
            },
            {
                name: 'shop.point_transactions',
                path: '/user/point-transactions',
                capabilities: ['manager'],
            },
            {
                name: 'shop.photo_wall',
                path: '/photo-wall',
                capabilities: ['manager'],
            },
        ]
    },
    {
        name: 'lottery.menus.name',
        icon: 'gift',
        capabilities: ['manager'],
        children: [
            {
                name: 'lottery.menus.settings',
                path: '/lottery/settings',
                capabilities: [],
            },
            {
                name: 'lottery.menus.prizes',
                path: '/lottery/prizes',
                capabilities: ['manager'],
            },
            {
                name: 'lottery.menus.records',
                path: '/lottery/records',
                capabilities: ['manager'],
            },
        ]
    },
    {
        name: 'sidebar.others',
        icon: 'compass',
        capabilities: [],
        children: [
            {
                name: 'sidebar.material_manage',
                path: '/material/list',
                capabilities: [],
            },
            {
                name: 'sidebar.block_manage',
                path: '/block/list',
                capabilities: [],
            },
            {
                name: 'sidebar.snippet_manage',
                path: '/snippet/list',
                capabilities: [],
            },
            {
                name: 'sidebar.menu_manage',
                path: '/menu/list',
                capabilities: [],
            },
            {
                name: 'sidebar.link_manage',
                path: '/link/list',
                capabilities: [],
            },
            {
                name: 'sidebar.region_manage',
                path: '/district/list',
                capabilities: [],
            },
            {
                name: 'sidebar.ad_manage',
                path: '/ad/list',
                capabilities: [],
            },
            {
                name: 'sidebar.kefu_manage',
                path: '/kefu/list',
                capabilities: [],
            },
        ]
    },
];
