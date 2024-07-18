import PageList from "./PageList";
import PageEdit from "./PageEdit";

module.exports = [
    {
        path: '/page/list',
        component: PageList,
        meta: {title: '页面管理', capabilities: ['administrator']}
    },
    {
        path: '/page/new',
        component: PageEdit,
        meta: {title: '新建页面', capabilities: ['administrator']}
    },
    {
        path: '/page/edit/:id?',
        component: PageEdit,
        meta: {title: '编辑页面', capabilities: ['administrator']}
    },
]
