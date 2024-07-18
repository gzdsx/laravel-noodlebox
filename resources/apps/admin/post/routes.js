import PostList from "./PostList";
import PostEdit from "./PostEdit";

module.exports = [
    {
        path: '/post/list',
        component: PostList,
        meta: {title: '文章管理', capabilities: ['administrator', 'manager']}
    },
    {
        path: '/post/new',
        component: PostEdit,
        meta: {title: '添加文章', capabilities: ['administrator', 'manager']}
    },
    {
        path: '/post/edit/:id?',
        component: PostEdit,
        meta: {title: '编辑文章', capabilities: ['administrator', 'manager']}
    },
]
