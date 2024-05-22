import General from "./General.vue";
import Register from "./Register";
import Attach from "./Attach";
import Water from "./Water.vue";
import Mail from "./Mail.vue";
import Theme from "./Theme.vue";

module.exports = [
    {path: '/settings/general', component: General, meta: {title: '基础设置'}},
    {path: '/settings/register', component: Register, meta: {title: '注册设置'}},
    {path: '/settings/attach', component: Attach, meta: {title: '附件设置'}},
    {path: '/settings/water', component: Water, meta: {title: '水印设置'}},
    {path: '/settings/mail', component: Mail, meta: {title: '邮件设置'}},
    {path: '/settings/theme', component: Theme, meta: {title: '主题设置'}},
]