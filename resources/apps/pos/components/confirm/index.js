import PosConfirm from "./PosConfirm.vue";

export default {
    install(Vue) {
        const Confirm = Vue.extend(PosConfirm);
        Vue.prototype.$showConfirm = function (options) {
            const dom = new Confirm({
                el: document.createElement('div'),
                data() {
                    return {
                        ...options
                    }
                }
            });

            // 把 实例化的 toast.vue 添加到 body 里
            document.body.appendChild(dom.$el);

            dom.show = true;
        };
    }
}