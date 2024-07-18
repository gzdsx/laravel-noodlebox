import ExpressList from "./ExpressList";
import BlockList from "./BlockList";
import BlockEdit from "./BlockEdit";
import AdList from "./AdList";
import MenuList from "./MenuList";
import MenuItem from "./MenuItem";
import MaterialList from "./MaterialList";
import LinkList from "./LinkList";
import DistrictList from "./DistrictList";
import KefuList from "./KefuList";
import SnippetList from "./SnippetList";

module.exports = [
    {
        path: '/express/list',
        component: ExpressList,
        meta: {title: '快递管理', capabilities: []}
    },
    {
        path: '/block/list',
        component: BlockList,
        meta: {title: '模块管理', capabilities: []}
    },
    {
        path: '/block/new',
        component: BlockEdit,
        meta: {title: '添加模块', capabilities: []}
    },
    {
        path: '/block/edit/:id?',
        component: BlockEdit,
        meta: {title: '编辑管理', capabilities: []}
    },
    {
        path: '/ad/list',
        component: AdList,
        meta: {title: '广告管理', capabilities: []}
    },
    {
        path: '/menu/list',
        component: MenuList,
        meta: {title: '菜单管理', capabilities: []}
    },
    {
        path: '/menu/item/:menu_id?',
        component: MenuItem,
        meta: {title: '项目管理', capabilities: []}
    },
    {
        path: '/material/list',
        component: MaterialList,
        meta: {title: '素材管理', capabilities: []}
    },
    {
        path: '/link/list',
        component: LinkList,
        meta: {title: '链接管理', capabilities: []}
    },
    {
        path: '/district/list',
        component: DistrictList,
        meta: {title: '区位管理', capabilities: []}
    },
    {
        path: '/kefu/list',
        component: KefuList,
        meta: {title: '客服管理', capabilities: []}
    },
    {
        path: '/snippet/list',
        component: SnippetList,
        meta: {title: '内容片段', capabilities: []}
    }
]