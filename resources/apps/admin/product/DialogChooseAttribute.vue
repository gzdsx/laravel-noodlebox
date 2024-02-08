<template>
    <el-dialog
            title="选择常用型号"
            width="60%"
            custom-class="product-attribute-dialog"
            :visible="value"
            :close-on-click-modal="false"
            :close-on-press-escape="false"
            append-to-body
            closeable
            @close="close"
    >
        <div class="attribute-select-wrapper">
            <div class="attribute-select-left">
                <div class="attribute-list">
                    <div
                            class="attribute-item"
                            v-for="(attr,index) in attributes"
                            :key="index"
                            :class="{'attribute-item__active':attr.id===theAttribute.id,'attribute-item__disabled':selectedAttriutes.indexOf(attr.name) !== -1}"
                            @click="selectAttr(attr)"
                    >
                        <div class="attribute-item__title">{{ attr.name }}</div>
                        <i class="el-icon-arrow-right"></i>
                    </div>
                </div>
            </div>
            <div class="attribute-select-options">
                <div class="attribute-options__wrapper">
                    <div class="attribute-options">
                        <div
                            class="attribute-option"
                            v-for="(o,i) in theAttribute.options"
                            :key="i"
                            :class="{'attribute-option__active':selectedOptions.indexOf(o) !== -1}"
                            @click="selectOption(o)"
                        >{{ o.value }}
                        </div>
                    </div>
                </div>
                <div class="attribute-actions">
                    <el-button size="small" @click="close">取消</el-button>
                    <el-button type="primary" size="small" @click="handleSubmit">确认添加</el-button>
                </div>
            </div>
        </div>
    </el-dialog>
</template>

<script>
import ApiService from "../utils/ApiService";

export default {
    name: "DialogChooseAttribute",
    props: {
        value: Boolean,
        selectedAttriutes: {
            type: Array,
            default() {
                return [];
            }
        }
    },
    data() {
        return {
            attributes: [],
            theAttribute: {name: '', options: []},
            selectedOptions: []
        }
    },
    methods: {
        close() {
            this.$emit('input', false);
        },
        fetchList() {
            ApiService.get('/products/attributes').then(response => {
                this.attributes = response.result.items;
            }).catch(reason => {

            }).finally(() => {

            })
        },
        selectAttr(attr) {
            if (this.selectedAttriutes.indexOf(attr.name) !== -1) {
                return;
            }
            this.theAttribute = attr;
            this.selectedOptions = [];
        },
        selectOption(o) {
            const index = this.selectedOptions.indexOf(o);
            if (index === -1) {
                this.selectedOptions.push(o);
            } else {
                this.selectedOptions.splice(index, 1);
            }
        },
        handleSubmit() {
            let {theAttribute, selectedOptions} = this;
            this.$emit('select', {
                name: theAttribute.name,
                options: selectedOptions
            });
            this.close();
            this.theAttribute = {name: '', options: []};
            this.selectedOptions = [];
        }
    },
    mounted() {
        this.fetchList();
    }
}
</script>

<style scoped>

</style>