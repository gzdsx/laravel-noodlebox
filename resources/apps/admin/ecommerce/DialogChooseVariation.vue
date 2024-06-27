<template>
    <el-dialog
            title="选择常用变量"
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
                            v-for="(v,index) in variationList"
                            :key="index"
                            :class="{'attribute-item__active':theVariation.id===v.id}"
                            @click="selectVar(v)"
                    >
                        <div class="attribute-item__title">{{ v.name }}</div>
                        <i class="el-icon-arrow-right"></i>
                    </div>
                </div>
            </div>
            <div class="attribute-select-options">
                <div class="attribute-options__wrapper">
                    <div class="attribute-options">
                        <div
                            class="attribute-option"
                            v-for="(o,i) in theVariation.options"
                            :key="i"
                            :class="{'attribute-option__active':selectedOptions.indexOf(o) !== -1}"
                            @click="selectOption(o)"
                        >{{ o.title }} ({{o.price}})
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
    name: "DialogChooseVariation",
    props: {
        value: Boolean
    },
    data() {
        return {
            variationList: [],
            theVariation: {name: '', multiple: false, options: []},
            selectedOptions: []
        }
    },
    methods: {
        close() {
            this.$emit('input', false);
        },
        fetchList() {
            ApiService.get('/products/variations?limit=1000').then(response => {
                this.variationList = response.data.items;
            }).catch(reason => {

            }).finally(() => {

            })
        },
        selectVar(v) {
            this.theVariation = v;
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
            let {theVariation, selectedOptions} = this;
            this.$emit('select', {
                ...theVariation,
                options: selectedOptions
            });
            this.close();
            this.theVariation = {name: '', multiple: false, options: []};
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