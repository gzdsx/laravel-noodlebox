import E from 'wangeditor';

export default class MenuImage extends E.BtnMenu {
    constructor(editor) {
        let $elem = E.$('<div class="w-e-menu" data-title="图片"><i class="w-e-icon-image"></i></div>');
        super($elem, editor);
        this.config = editor.config;
    }

    clickHandler() {
        if (this.config.onClickImageMenu) {
            this.config.onClickImageMenu();
        }
    }
    tryChangeActive(){

    }
}