<template>
    <pos-dialog :title="lineItem.name" :visible="value" @close="close">
        <template #actions>
            <button class="btn btn-info" @click="submit">
                Save Product
            </button>
        </template>
        <div class="pos-dialog-product-wrapper">
            <div class="pos-dialog-product-col-variation" ref="scroll">
                <template v-if="lineItem.attributes">
                    <div v-for="(attr,k) in lineItem.attributes" :key="k">
                        <div class="form-group" v-if="attr.type==='multiple'">
                            <div class="form-label">
                                <span>{{ attr.name }}</span>
                                <span>(Multiple)</span>
                            </div>
                            <div class="product-variations">
                                <div
                                        class="product-variation"
                                        v-for="(op,i) in attr.options"
                                        :key="i"
                                        :class="{'product-variation__active':attr.value[i]}"
                                        @click="selectVar(attr,i)"
                                >
                                    {{ op.title }}(€{{ op.price || 0 }})
                                </div>
                            </div>
                        </div>
                        <div class="form-group" v-else>
                            <div class="form-label">
                                <span>{{ attr.name }}</span>
                                <span v-if="attr.type==='multiple'">(Multiple)</span>
                            </div>
                            <div class="product-variations">
                                <div
                                        class="product-variation"
                                        v-for="(op,i) in attr.options"
                                        :key="i"
                                        :class="{'product-variation__active':attr.value===i}"
                                        @click="selectVar(attr,i)"
                                >
                                    {{ op.title }}(€{{ op.price || 0 }})
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
            <div class="pos-dialog-product-col-right">
                <div class="form-group">
                    <div class="form-input-label">Price</div>
                    <h3 class="text-primary">{{ lineItem.price }}</h3>
                </div>
                <div class="form-group">
                    <div class="form-input-label">Quantity</div>
                    <number-control v-model="lineItem.quantity"/>
                </div>
                <div class="form-group">
                    <div class="form-input-label">Subtotal</div>
                    <h3 class="text-primary">€{{ $toAmount(lineItem.subtotal) }}</h3>
                </div>
                <div class="form-group pos-dialog-product-comments">
                    <div class="pos-dialog-product-comment" v-for="(comment,i) in lineItem.comments" :key="i">
                        <div class="title">{{ comment.type|capitalize }}-{{ comment.name }}</div>
                        <div class="price">€{{ $toAmount(comment.price) }}</div>
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-info" @click="showComment">Add Comment</button>
                </div>
            </div>
        </div>

        <div class="gzdsx-pos-dialog__footer" slot="footer">
            <div class="pos-dialog-product-footer">
                <div class="flex-grow-1 d-flex column-gap-1">
                    <button class="btn btn-light" @click="prev">Prev</button>
                    <button class="btn btn-light" @click="next">Next</button>
                </div>
                <button class="btn btn-info" @click="submit">
                    Save Product
                </button>
            </div>
        </div>

        <dialog-comment :default-comments="lineItem.comments" @submit="selectComments" v-model="showCommentDialog"/>
    </pos-dialog>
</template>

<script>
import NumberControl from "./NumberControl.vue";
import DialogComment from "./DialogComment.vue";

export default {
    name: "DialogProduct",
    components: {DialogComment, NumberControl},
    props: {
        value: Boolean,
        defaultLineItem: {
            type: Object,
            default() {
                return {
                    attributes: [],
                    comments: [],
                    image: {},
                }
            }
        },
    },
    data() {
        return {
            variations: [],
            variation: {},
            selectedVars: [],
            regular_price: 0,
            showCommentDialog: false,
            lineItem: {
                attributes: [],
                comments: [],
                image: {},
            }
        }
    },
    computed: {
        disabled() {
            if (!this.lineItem.attributes) {
                return true;
            }
            return Object.keys(this.variation).length === 0;
        }
    },
    watch: {
        defaultLineItem(val) {
            this.lineItem = val;
        }
    },
    methods: {
        close() {
            this.$emit('input', false);
        },
        submit() {
            this.$emit('submit', this.lineItem);
            this.close();
        },
        selectVar(attr, i) {
            this.$beep.play();
            if (attr.type === 'multiple') {
                attr.value[i] = attr.value[i] === false || attr.value[i] === '';
                this.$forceUpdate();
            } else {
                attr.value = i;
            }
        },
        showComment() {
            this.showCommentDialog = true;
        },
        selectComments(v) {
            this.lineItem.comments = v;
        },
        prev() {
            this.$refs.scroll.scrollTop -= 50;
        },
        next() {
            this.$refs.scroll.scrollTop += 50;
        }
    },
    mounted() {
        this.lineItem = this.defaultLineItem;
    }
}
</script>

<style scoped>

</style>