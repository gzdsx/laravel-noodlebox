import Category from "./Category.vue";

module.exports = [
    {path: '/category/:taxonomy?', component: Category, meta: {title: '分类管理', capabilities: []}},
]