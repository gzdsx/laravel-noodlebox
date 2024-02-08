export default class CustomImageMenu {
    constructor() {
        this.title = '图片'; // 自定义菜单标题
        this.iconSvg = '<svg viewBox="0 0 1024 1024"><path d="M959.877 128l0.123 0.123v767.775l-0.123 0.122H64.102l-0.122-0.122V128.123l0.122-0.123h895.775zM960 64H64C28.795 64 0 92.795 0 128v768c0 35.205 28.795 64 64 64h896c35.205 0 64-28.795 64-64V128c0-35.205-28.795-64-64-64zM832 288.01c0 53.023-42.988 96.01-96.01 96.01s-96.01-42.987-96.01-96.01S682.967 192 735.99 192 832 234.988 832 288.01zM896 832H128V704l224.01-384 256 320h64l224.01-192z"></path></svg>'; // 可选
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
        if (config.onClickMenuImage) {
            config.onClickMenuImage();
        }
    }
}