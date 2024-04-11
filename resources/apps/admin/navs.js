export default [
    {
        name: 'sidebar.dashboard',
        icon: 'speedometer',
        children: [
            {
                name: 'sidebar.dashboard',
                path: '/',
                isLink: false
            }
        ]
    },
    {
        name: 'sidebar.settings',
        icon: 'gear-wide',
        children: [
            {
                name: 'sidebar.settings_general',
                path: '/settings/general',
                isLink: false
            },
            {
                name: 'sidebar.settings_register',
                path: '/settings/register',
                isLink: false
            },
            {
                name: 'sidebar.settings_attach',
                path: '/settings/attach',
                isLink: false
            },
            {
                name: 'sidebar.settings_watermark',
                path: '/settings/water',
                isLink: false
            },
            {
                name: 'sidebar.settings_mail',
                path: '/settings/mail',
                isLink: false
            },
        ]
    },
    {
        name: 'sidebar.users',
        icon: 'people',
        children: [
            {
                name: 'sidebar.user_add',
                path: '/user/new',
                isLink: false,
                visible: true
            },
            {
                name: 'sidebar.user_manage',
                path: '/user/list',
                isLink: false,
                visible: true
            },
            {
                name: 'sidebar.user_group',
                path: '/user/group',
                isLink: false,
                visible: true
            }
        ]
    },
    {
        name: 'sidebar.pages',
        icon: 'box',
        children: [
            {
                name: 'sidebar.page_addnew',
                path: '/page/new',
                isLink: false
            },
            {
                name: 'sidebar.page_manage',
                path: '/page/list',
                isLink: false
            }
        ]
    },
    {
        name: 'sidebar.posts',
        icon: 'pencil-square',
        children: [
            {
                name: 'sidebar.post_addnew',
                path: '/post/new',
                isLink: false
            },
            {
                name: 'sidebar.post_manage',
                path: '/post/list',
                isLink: false
            },
            {
                name: 'sidebar.post_category',
                path: '/category',
                isLink: false
            }
        ]
    },
    {
        name: '电商',
        icon: 'bag',
        children: [
            {
                name: '添加产品',
                path: '/product/new',
                isLink: false
            },
            {
                name: '产品管理',
                path: '/product/list',
                isLink: false
            },
            {
                name: '分类管理',
                path: '/category/product',
                isLink: false
            },
            {
                name: '常用变量',
                path: '/product/variations',
                isLink: false
            },
            {
                name: '门店管理',
                path: '/shop/list',
                isLink: false
            },
            {
                name: '配送区域',
                path: '/shipping-zone/list',
                isLink: false
            },
            {
                name: '订单管理',
                path: '/order/list',
                isLink: false
            },
            {
                name: '配送员管理',
                path: '/deliveryers',
                isLink: false
            },
            {
                name: '照片墙',
                path: '/photo-wall',
                isLink: false
            },
        ]
    },
    {
        name: 'sidebar.others',
        icon: 'compass',
        children: [
            {
                name: 'sidebar.material_manage',
                path: '/material/list',
                isLink: false
            },
            {
                name: 'sidebar.block_manage',
                path: '/block/list',
                isLink: false
            },
            {
                name: 'sidebar.snippet_manage',
                path: '/snippet/list',
                isLink: false
            },
            {
                name: 'sidebar.menu_manage',
                path: '/menu/list',
                isLink: false
            },
            {
                name: 'sidebar.link_manage',
                path: '/link/list',
                isLink: false
            },
            {
                name: 'sidebar.region_manage',
                path: '/district/list',
                isLink: false
            },
            {
                name: 'sidebar.ad_manage',
                path: '/ad/list',
                isLink: false
            },
            {
                name: 'sidebar.kefu_manage',
                path: '/kefu/list',
                isLink: false
            },
        ]
    },
];
