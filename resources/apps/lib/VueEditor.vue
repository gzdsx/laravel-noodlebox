<template>
    <div>
        <div ref="toolbar" class="we-toolbar"></div>
        <div class="w-text-container" :style="{'height':height+'px'}">
            <div ref="editor"></div>
        </div>
        <media-dialog v-model="showMediaDialog" multiple @confirm="insertImage"/>
    </div>
</template>

<script>
import WangEditor from "wangeditor";
import MenuImage from "./menus/MenuImage";

export default {
    name: "VueEditor",
    props: {
        value: {
            type: String,
            default: ''
        },
        height: {
            type: Number,
            default: 500
        },
    },
    data() {
        return {
            editor: null,
            content: this.value,
            showMediaDialog: false,
        }
    },
    mounted() {
        this.initEditor();
        this.editor.txt.html(this.value);
    },
    watch: {
        value(val) {
            if (val != this.editor.txt.html()) {
                this.editor.txt.html(val);
            }
        }
    },
    methods: {
        initEditor() {
            let that = this;
            const editor = new WangEditor(this.$refs.toolbar, this.$refs.editor);
            editor.menus.extend('customimage', MenuImage);
            editor.config.zIndex = 0;
            editor.config.height = that.height;
            editor.config.menus = [
                'head',
                'bold',
                'fontSize',
                'fontName',
                'italic',
                'underline',
                'strikeThrough',
                'indent',
                'lineHeight',
                'foreColor',
                'backColor',
                'link',
                'list',
                'todo',
                'justify',
                'quote',
                'emoticon',
                'customimage',
                'video',
                'table',
                'code',
                'splitLine',
            ];
            editor.config.onClickImageMenu = function (e) {
                that.showMediaDialog = true;
            }
            // 配置 onchange 回调函数
            editor.config.onchange = function (html) {
                //console.log('change 之后最新的 html', html)
                that.content = html;
                that.$emit('input', html);
            }

            // editor.config.excludeMenus = [
            //     'redo',
            //     'undo',
            //     'image',
            //     'video'
            // ];

            editor.create();
            this.editor = editor;
        },
        insertImage(images) {
            for (let img of images) {
                this.editor.cmd.do('insertHTML', `<img src="${img.url}" style="max-width:100%;"/>`);
            }
        }
    }
}
</script>

<style lang="scss">
.we-toolbar {
    background-color: #FFF;
    border: 1px solid #c9d8db;
    border-bottom: 1px solid #EEE;
}

.w-text-container {
    overflow-y: auto;
    border: 1px solid #c9d8db;
    border-top: 0;

    * {
        max-width: 100% !important;
    }

    .w-e-text-container {
        border: none !important;
        padding: 0;
    }

    .w-e-text {
        box-sizing: border-box;
        padding-left: 10px;
        padding-right: 10px;
        min-height: 200px;

        * {
            max-width: 100% !important;
        }
    }

    .w-e-text table td, .w-e-text table th {
        height: 30px;
    }

    .w-e-tooltip {
        column-gap: 10px;
        padding-left: 10px;
        padding-right: 10px;
    }
}
</style>
