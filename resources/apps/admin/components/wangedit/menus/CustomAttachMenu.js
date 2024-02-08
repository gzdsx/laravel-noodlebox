export default class CustomAttachMenu {
    constructor() {
        this.title = '附件'; // 自定义菜单标题
        this.iconSvg = '<svg t="1707110937391" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="9545" xmlns:xlink="http://www.w3.org/1999/xlink" width="64" height="64"><path d="M768 153.6H358.4a358.4 358.4 0 1 0 0 716.8h409.6v-102.4H358.4A256 256 0 0 1 358.4 256h409.6a153.6 153.6 0 0 1 0 307.2H358.4a51.2 51.2 0 0 1 0-102.4h409.6V358.4H358.4a153.6 153.6 0 1 0 0 307.2h409.6a256 256 0 0 0 0-512z" p-id="9546"></path></svg>'; // 可选
        this.tag = 'button';
    }

    // 获取菜单执行时的 value ，用不到则返回空 字符串或 false
    getValue(editor) {                              // JS 语法
        return ''
    }

    // 菜单是否需要激活（如选中加粗文本，“加粗”菜单会激活），用不到则返回 false
    isActive(editor) {                    // JS 语法
        return false
    }

    // 菜单是否需要禁用（如选中 H1 ，“引用”菜单被禁用），用不到则返回 false
    isDisabled(editor) {                     // JS 语法
        return false
    }

    // 点击菜单时触发的函数
    exec(editor, value) {                              // JS 语法
        //console.log(editor);
        const config = editor.getConfig();
        if (config.onClickMenuAttach) {
            config.onClickMenuAttach();
        }
    }
}