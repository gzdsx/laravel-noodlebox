import PostList from "./PostList";
import PostEdit from "./PostEdit";

module.exports = [
    {path: '/post/list', component: PostList, meta: {title: '文章管理', group: 'post'}},
    {path: '/post/new', component: PostEdit, meta: {title: '添加文章', group: 'post'}},
    {path: '/post/edit/:id?', component: PostEdit, meta: {title: '编辑文章', group: 'post'}},
]
