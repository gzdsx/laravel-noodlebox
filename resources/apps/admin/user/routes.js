import UserList from "./UserList";
import UserEdit from "./UserEdit";
import UserGroup from "./UserGroup";
import PointTransaction from "./PointTransaction.vue";

module.exports = [
    {path: '/user/list', component: UserList, meta: {title: '用户管理', group: 'user'}},
    {path: '/user/new', component: UserEdit, meta: {title: '新用户', group: 'user'}},
    {path: '/user/edit/:id?', component: UserEdit, name: 'user-edit', meta: {title: '编辑用户', group: 'user'}},
    {path: '/user/group', component: UserGroup, meta: {title: '分组管理', group: 'user'}},
    {path: '/user/point-transactions', component: PointTransaction, meta: {title: '积分明细', group: 'user'}},
]
