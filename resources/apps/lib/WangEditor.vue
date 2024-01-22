<template>
    <div>
        <div class="we-toolbar" ref="toolbar"></div>
        <div class="we-editor" ref="editor" :style="{'height':height+'px'}"></div>
        <media-dialog multiple :options="{type:'image'}" v-model="showImageDialog" @confirm="onChooseImages"/>
        <media-dialog v-model="showVideoDialog" @confirm="onChooseVideo"/>
    </div>
</template>

<script>
import {createEditor, createToolbar, Boot, i18nChangeLanguage} from "@wangeditor/editor";
import CustomImageMenu from "./menus/CustomImageMenu";

i18nChangeLanguage('en');
Boot.registerMenu({
    key: 'customimage',
    factory() {
        return new CustomImageMenu();
    }
});
export default {
    name: "WangEditor",
    components: {},
    props: {
        value: {
            type: String,
            default: ''
        },
        height: {
            type: String,
            default: '500'
        },
        defaultHtml: {
            type: String,
            default: ''
        }
    },
    data() {
        return {
            editor: null,
            toolbar: null,
            curValue: '',
            showImageDialog: false,
            showVideoDialog: false
        }
    },
    watch: {
        value(newVal) {
            newVal === this.curValue || this.setHtml(newVal);
        }
    },
    methods: {
        initEditor() {
            if (this.$el) {
                const that = this;
                const editor = createEditor({
                    selector: that.$refs.editor,
                    html: this.defaultHtml || this.value || "",
                    mode: 'default', // or 'simple'
                    config: {
                        zIndex: 0,
                        placeholder: 'Type here...',
                        onCreated(editor) {
                            that.editor = Object.seal(editor);
                            that.$emit('created', that.editor);
                        },
                        onChange(o) {
                            const r = o.getHtml();
                            that.curValue = r;
                            that.$emit("input", r);
                            that.$emit("onChange", o);
                        },
                        onClickMenuImage() {
                            that.showImageDialog = true;
                        }
                    }
                });

                const toolbarConfig = {
                    excludeKeys: ['group-image', 'undo', 'redo', '|', 'todo'],
                    insertKeys: {
                        index: 23,
                        keys: ['customimage']
                    }
                }
                this.toolbar = createToolbar({
                    editor,
                    selector: this.$refs.toolbar,
                    config: toolbarConfig,
                    mode: 'default', // or 'simple'
                });

                console.log(editor.getMenuConfig('fontSize'));
            }
        },
        setHtml: function (e) {
            var t = this.editor;
            null != t && t.setHtml(e)
        },
        onChooseImages(images) {
            for (let img of images) {
                //this.editor.insertData(`<img src="${img.url}" class="img-fluid" />`);
                this.editor.insertNode({
                    type: 'image',
                    src: img.url,
                    alt: '',
                    children: [{text: ''}]
                });
            }
        },
        onChooseVideo() {

        }
    },
    mounted() {
        this.initEditor();
    },
    beforeDestroy() {
        if (this.editor) {
            this.editor.destroy();
        }
    }
}
</script>
<style src="@wangeditor/editor/dist/css/style.css"></style>
<style lang="scss">
.we-toolbar {
    border: 1px solid #c9d8db;
}

.we-editor {
    border: 1px solid #c9d8db;
    border-top: 0;

    * {
        max-width: 100% !important;
        white-space: pre-wrap !important;
        word-wrap: break-word !important;
    }

    td, th {
        line-height: 2 !important;
    }
}
</style>