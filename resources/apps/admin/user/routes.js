import UserList from "./UserList";
import UserEdit from "./UserEdit";
import UserGroup from "./UserGroup";
import PointTransaction from "./PointTransaction.vue";
import Roles from "./Roles.vue";

module.exports = [
    {
        path: '/user/list',
        component: UserList,
        meta: {title: '用户管理', capabilities: []}
    },
    {
        path: '/user/new',
        component: UserEdit,
        meta: {title: '添加用户', capabilities: []}
    },
    {
        path: '/user/edit/:id?',
        component: UserEdit,
        name: 'user-edit',
        meta: {title: '编辑用户', capabilities: []}
    },
    // {
    //     path: '/user/group',
    //     component: UserGroup,
    //     meta: {title: '分组管理', capabilities: ['administrator']}
    // },
    {
        path: '/user/point-transactions',
        component: PointTransaction,
        meta: {title: '积分明细', capabilities: ['manager']}
    },
    {
        path: '/user/roles',
        component: Roles,
        meta: {title: '角色管理', capabilities: []}
    },
]
