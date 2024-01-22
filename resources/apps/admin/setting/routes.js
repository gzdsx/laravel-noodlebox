import Basic from "./Basic.vue";
import Register from "./Register";
import Attach from "./Attach";
import Water from "./Water.vue";
import Mail from "./Mail.vue";
import Sterling from "./Sterling";

module.exports = [
    {path: '/settings/basic', component: Basic, meta: {title: '基础设置'}},
    {path: '/settings/register', component: Register, meta: {title: '注册设置'}},
    {path: '/settings/attach', component: Attach, meta: {title: '附件设置'}},
    {path: '/settings/water', component: Water, meta: {title: '水印设置'}},
    {path: '/settings/mail', component: Mail, meta: {title: '邮件设置'}},
    {path: '/settings/sterling', component: Sterling, meta: {title: 'Sterling'}},
]