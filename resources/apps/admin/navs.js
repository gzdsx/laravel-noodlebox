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
                path: '/settings/basic',
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
            {
                name: 'sidebar.settings_sterling',
                path: '/settings/sterling',
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
                path: '/categories',
                isLink: false
            }
        ]
    },
    {
        name: 'Services',
        icon: 'telegram',
        children: [
            {
                name: 'sidebar.post_addnew',
                path: '/post/new?type=service',
                isLink: false
            },
            {
                name: 'sidebar.post_manage',
                path: '/post/list?type=service',
                isLink: false
            },
            {
                name: 'sidebar.post_category',
                path: '/categories?taxonomy=service',
                isLink: false
            }
        ]
    },
    {
        name: 'Buildium',
        icon: 'house-door',
        children: [
            {
                name: 'Forms',
                path: '/buildium/form-list'
            },
            {
                name: 'Resources',
                path: '/buildium/resource-list'
            },
            {
                name: 'Rental Properties',
                path: '/buildium/rental-properties'
            },
            {
                name: 'Rental Units',
                path: '/buildium/rental-units'
            },
            {
                name: 'Rental Listings',
                path: '/buildium/rental-listings'
            },
            {
                name: 'Associations',
                path: '/buildium/associations'
            },
            {
                name: 'Association Units',
                path: '/buildium/association-units'
            }
        ]
    },
    {
        name: 'Real Estate',
        icon: 'lightbulb',
        children: [
            {
                name: 'All Properties',
                path: '/realestate/property-list'
            },
            {
                name: 'New Property',
                path: '/realestate/property-new'
            },
            {
                name: 'Features',
                path: '/realestate/features'
            },
            {
                name: 'Property Types',
                path: '/realestate/property-types'
            },
            {
                name: 'Building Types',
                path: '/realestate/building-types'
            },
            {
                name: 'Parking Types',
                path: '/realestate/parking-types'
            },
            {
                name: 'Property Titles',
                path: '/realestate/titles'
            },
            {
                name: 'Cities',
                path: '/realestate/cities'
            },
            {
                name: 'Agents',
                path: '/realestate/agents'
            },
            {
                name: 'Offices',
                path: '/offices'
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
