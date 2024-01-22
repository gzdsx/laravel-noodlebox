<template>
    <div class="quill-editor">
        <slot name="toolbar"/>
        <div ref="editor" :style="{'height':height+'px'}"></div>
        <media-dialog v-model="showImageDialog" multiple @confirm="onChooseImage"/>
    </div>
</template>

<script>
import Quill from "quill";

export default {
    name: "QuillEditor",
    props: {
        height: {
            type: Number,
            default: 400
        },
        value: String
    },
    data() {
        return {
            toolbar: null,
            editor: null,
            content: '',
            showImageDialog: false,
            showVideoDialog: true
        }
    },
    mounted() {
        this.initEditor();
    },
    beforeDestroy() {
        this.editor = null
        delete this.editor
    },
    watch: {
        value(newVal, oldVal) {
            if (this.editor) {
                if (newVal && newVal !== this.content) {
                    this.content = newVal
                    this.editor.pasteHTML(newVal)
                } else if (!newVal) {
                    this.editor.setText('')
                }
            }
        },
    },
    methods: {
        initEditor() {
            if (this.$el) {
                const quill = new Quill(this.$refs.editor, {
                    theme: 'snow',
                    boundary: document.body,
                    modules: {
                        toolbar: [
                            ['bold', 'italic', 'underline', 'strike'],
                            ['blockquote', 'code-block'],
                            [{'header': 1}, {'header': 2}],
                            [{'list': 'ordered'}, {'list': 'bullet'}],
                            [{'script': 'sub'}, {'script': 'super'}],
                            [{'indent': '-1'}, {'indent': '+1'}],
                            [{'direction': 'rtl'}],
                            [{'size': ['small', false, 'large', 'huge']}],
                            [{'header': [1, 2, 3, 4, 5, 6, false]}],
                            [{'color': []}, {'background': []}],
                            [{'font': []}],
                            [{'align': []}],
                            ['clean'],
                            ['link', 'image', 'video']
                        ]
                    },
                    placeholder: 'Insert text here ...',
                    readOnly: false
                });

                quill.on('text-change', (delta, oldDelta, source) => {
                    let html = this.$refs.editor.children[0].innerHTML
                    // const quill = this.quill
                    // const text = this.quill.getText()
                    // if (html === '<p><br></p>') html = '';
                    this.content = html
                    this.$emit('input', this.content);
                    // this.$emit('change', { html, text, quill })
                });

                var toolbar = quill.getModule('toolbar');
                toolbar.addHandler('image', () => {
                    this.showImageDialog = true;
                });

                console.log(quill);
                this.editor = quill;
                this.toolbar = toolbar;
            }
        },
        onChooseImage(images) {
            let range = this.editor.getSelection(true);
            for (let image of images) {
                this.editor.insertEmbed(range, 'image', image.url);
                range++;
            }
        }
    }
}
</script>

<style lang="scss">
@import "~quill/dist/quill.core.css";
@import "~quill/dist/quill.snow.css";

.ql-editor {
    font-size: 16px;
}
</style>