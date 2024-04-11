<template>
    <pos-dialog title="Comment" :visible="value" @close="close">
        <div class="pos-comment__wrapper">
            <div class="pos-comment__content" ref="scrollView">
                <div class="pos-comment__list">
                    <div
                            class="pos-comment__list__item"
                            v-for="(item, index) in comments"
                            :key="index"
                            :style="{'background-color': item.color}"
                            @click="selectItem(item,index)"
                    >
                        <div class="title">{{ item.name }}</div>
                        <div class="price">€{{ $toAmount(item.price) }}</div>
                    </div>
                </div>
            </div>
            <div class="pos-comment__types">
                <div
                        class="pos-comment__type"
                        v-for="(type, index) in comment_types"
                        :key="index"
                        :class="{'pos-comment__type__active': type === comment_type}"
                        @click="selectType(type)"
                >
                    {{ type }}
                </div>
                <div
                        class="pos-comment__type pos-comment__type__remove"
                        :class="{'pos-comment__type__active': 'delete' === comment_type}"
                        @click="deleteItem">delete
                </div>
            </div>
            <div class="pos-comment__cart">
                <div class="pos-comment__cart__items">
                    <div class="pos-comment__cart__item" v-for="(item, index) in selectedItems" :key="index">
                        <div class="title">{{ item.type|capitalize }}-{{ item.name }}</div>
                        <div class="price">€{{ $toAmount(item.price) }}</div>
                        <div class="remove" @click.stop="selectedItems.splice(index,1)">
                            <i class="yith-pos-icon-clear"></i>
                        </div>
                    </div>
                </div>
                <div class="pos-comment__cart__clear">
                    <button class="btn btn-light btn-block" @click="clear">Clear</button>
                </div>
            </div>
        </div>
        <template #actions>
            <button class="btn btn-info text-nowrap" @click="submit">Save Comment</button>
        </template>
        <div class="gzdsx-pos-dialog__footer" slot="footer">
            <div class="pos-comment__actionbar">
                <div class="d-flex column-gap-1">
                    <button class="btn btn-light" @click="prev">Prev</button>
                    <button class="btn btn-light" @click="next">Next</button>
                </div>
                <div class="pos-comment__actionbar__right">
                    <pos-input @inputChange="onNameChange" v-model="newComment.name">
                        <span slot="prepend">Name*</span>
                        <i slot="append" class="yith-pos-icon-clear clear" @click="clearName"></i>
                    </pos-input>
                    <pos-input v-model="newComment.price">
                        <span slot="prepend">Price*</span>
                    </pos-input>
                    <div class="pos-comment__color">
                        <button
                            class="btn btn-primary"
                            :style="{'background-color': newComment.color}"
                            @click="showColorPicker=!showColorPicker"
                        >Color</button>
                        <div class="color-picker" v-show="showColorPicker">
                            <pos-color-picker @select="showColorPicker=false" v-model="newComment.color"/>
                        </div>
                    </div>
                    <button class="btn btn-light" @click="saveComment">Add</button>
                    <button class="btn btn-info text-nowrap" @click="submit">Save Comment</button>
                </div>
            </div>
        </div>
    </pos-dialog>
</template>

<script>

import PosColorPicker from "./PosColorPicker.vue";

let all_comments = [];
export default {
    name: "DialogComment",
    components: {PosColorPicker},
    props: {
        value: Boolean,
        defaultComments: {
            type: Array,
            default() {
                return []
            }
        }
    },
    data() {
        return {
            newComment: {
                name: '',
                price: '0',
                color: '#FF6900'
            },
            comment: {},
            comments: [],
            comment_types: ['with', 'less', 'only', 'extra', 'no'],
            comment_type: '',
            comment_action: '',
            selectedItems: [],
            selectItem: function (item, index) {

            },
            showColorPicker: false
        }
    },
    watch: {
        defaultComments(val) {
            this.selectedItems = [...val];
        }
    },
    methods: {
        close() {
            this.$beep.play();
            this.reset();
            this.$emit('input', false);
        },
        saveComment() {
            this.$beep.play();
            const {name, price, color} = this.newComment;
            if (name && color) {
                let names = this.comments.filter(c => c.name === name);
                if (names.length > 0) return;
                this.$http.post('pos-comments', {name, price, color}).then(resp => {
                    if (resp.id) {
                        this.comments.push(resp);
                        all_comments.push(resp);
                    }
                    this.reset();
                });
            }
        },
        fetchComments() {
            this.$http.get('pos-comments').then(resp => {
                all_comments = resp.sort((a, b) => a.color > b.color ? -1 : a.color < b.color ? 1 : 0);
                this.comments = all_comments;
            });
        },
        remove() {
            this.$beep.play();
            this.selectedItems.pop();
        },
        clear() {
            this.$beep.play();
            this.comment_type = '';
            this.selectedItems = [];
            this.selectItem = () => {
            }
        },
        prev() {
            this.$beep.play();
            this.$refs.scrollView.scrollTop -= 100;
        },
        next() {
            this.$beep.play();
            this.$refs.scrollView.scrollTop += 100;
        },
        submit() {
            this.$beep.play();
            this.$emit('submit', this.selectedItems);
            this.close();
        },
        selectType(t) {
            this.$beep.play();
            this.comment_type = t;
            this.selectItem = (item, index) => {
                if (this.comment_type === '') return;
                const names = this.selectedItems.filter(c => c.name === item.name);
                if (names.length === 0) {
                    this.$beep.play();
                    this.selectedItems.push({
                        ...item,
                        type: this.comment_type
                    });
                }
            }
        },
        deleteItem() {
            this.$beep.play();
            this.comment_type = 'delete';
            this.selectItem = (item, index) => {
                this.selectItem = function () {

                }
                this.$http.delete('pos-comments/' + item.id).then(resp => {
                    this.comments.splice(index, 1);
                    this.comment_type = '';
                });
            }
        },
        onNameChange(v) {
            this.comments = all_comments.filter(c => {
                return c.name.toLowerCase().indexOf(v.toLowerCase()) !== -1;
            });
        },
        clearName() {
            this.newComment.name = '';
            this.comments = all_comments;
        },
        reset() {
            this.comment_type = '';
            this.selectedItems = [];
            this.newComment = {
                name: '',
                price: '0',
                color: '#198AFA'
            }
            this.comments = all_comments;
        }
    },
    mounted() {
        this.fetchComments();
        this.selectedItems = [...this.defaultComments];
    }
}
</script>

<style scoped>

</style>