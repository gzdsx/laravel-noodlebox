<template>
    <div>
        <div class="we-toolbar" ref="toolbar"></div>
        <div class="we-editor" ref="editor" :style="{'height':height+'px'}"></div>
        <media-dialog :multiple="multipleMedia" :options="{type:'image'}" v-model="showMediaDialog"
                      @confirm="onSelectedMedias"/>
    </div>
</template>

<script>
import {createEditor, createToolbar, Boot, i18nChangeLanguage} from "@wangeditor/editor";
import CustomImageMenu from "./menus/CustomImageMenu";
import CustomAttachMenu from "./menus/CustomAttachMenu";

i18nChangeLanguage('en');
Boot.registerMenu({
    key: 'customimage',
    factory() {
        return new CustomImageMenu();
    }
});

Boot.registerMenu({
    key: 'customattach',
    factory() {
        return new CustomAttachMenu();
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
            showVideoDialog: false,
            showMediaDialog: false,
            onSelectedMedias() {

            },
            multipleMedia: true
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
                            that.multipleMedia = true;
                            that.showMediaDialog = true;
                            that.onSelectedMedias = (images) => {
                                for (let img of images) {
                                    that.editor.insertNode({
                                        type: 'image',
                                        src: img.src,
                                        alt: '',
                                        children: [{text: ''}]
                                    });
                                }
                            }
                        },
                        onClickMenuAttach() {
                            that.multipleMedia = false;
                            that.showMediaDialog = true;
                            that.onSelectedMedias = (file) => {
                                //that.editor.dangerouslyInsertHtml(`<a href="${file.src}" target="_blank"><span>${file.name}</span></a>`);
                                that.editor.insertNode({
                                    type: 'link',
                                    url: file.src,
                                    target: '_blank',
                                    children: [{text: file.name}]
                                });
                            }
                        }
                    }
                });

                const toolbarConfig = {
                    excludeKeys: ['group-image', 'undo', 'redo', '|', 'todo'],
                    insertKeys: {
                        index: 23,
                        keys: ['customimage', 'customattach']
                    }
                }
                this.toolbar = createToolbar({
                    editor,
                    selector: this.$refs.toolbar,
                    config: toolbarConfig,
                    mode: 'default', // or 'simple'
                });

                //console.log(editor.getMenuConfig('fontSize'));
            }
        },
        setHtml: function (e) {
            var t = this.editor;
            null != t && t.setHtml(e)
        },
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
        word-wrap: break-word !important;
        word-break: break-all !important;
    }

    td, th {
        line-height: 2 !important;
    }

    a{
        text-decoration: underline;
        color: #198AFA;
    }
}

.w-e-modal button {
    line-height: 32px !important;
    padding: 0 15px;
}
</style>