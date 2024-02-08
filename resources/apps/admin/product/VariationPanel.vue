<template>
    <div class="sku-panel">
        <div class="sku-classify" v-for="(v,index) in variationList" :key="index">
            <div class="sku-classify-header">
                <div class="sku-classify-attribute">变量名称:</div>
                <div class="sku-classify-select">
                    <el-input size="medium" v-model="v.name"/>
                    <el-checkbox @change="onVariationTypeChange(v)" v-model="v.multiple">多选</el-checkbox>
                    <el-button size="medium" type="text" @click="chooseVariation(v)">
                        选择常用变量
                    </el-button>
                </div>
                <div class="flex"></div>
                <div class="el-icon-error sku-classify-del" @click="variationList.splice(index,1)"></div>
            </div>
            <div class="sku-classify-content">
                <div v-if="v.options.length">
                    <div class="variation-list">
                        <div class="variation-list__item">
                            <div class="col-label">选项名称</div>
                            <div class="col-price">价格</div>
                            <div class="col-price">默认选择</div>
                        </div>
                        <div class="variation-list__item" v-for="(o,i) in v.options" :key="i">
                            <div class="col-label">
                                <el-input size="medium" v-model="o.title"/>
                            </div>
                            <div class="col-price">
                                <el-input size="medium" v-model="o.price"/>
                            </div>
                            <div class="col-price">
                                <label class="el-checkbox" v-if="v.multiple">
                                    <div class="el-checkbox__input" :class="{'is-checked':o.selected}">
                                        <span class="el-checkbox__inner"></span>
                                        <input type="checkbox" class="el-radio__original" :checked="o.selected"
                                               @click="onCheckboxChange(o)"/>
                                    </div>
                                </label>
                                <label class="el-radio" v-else>
                                    <div class="el-radio__input" :class="{'is-checked':o.selected}">
                                        <span class="el-radio__inner"></span>
                                        <input type="radio" class="el-radio__original" :checked="o.selected"
                                               @click="onRadioChange(v,i)"/>
                                    </div>
                                </label>
                            </div>
                            <div>
                                <i class="el-icon-error" @click="v.options.splice(i,1)"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <el-button class="sku-item-add" size="small" icon="el-icon-plus"
                               @click="onAddOption(v)">
                        添加选项
                    </el-button>
                </div>
            </div>
        </div>
        <div class="sku-operate-buttons">
            <el-button size="small" icon="el-icon-plus" @click="onAddVariation">
                添加变量
            </el-button>
        </div>
        <dialog-choose-variation @select="onSelectedOptions" v-model="showDoalog"/>
    </div>
</template>

<script>
import DialogChooseVariation from "./DialogChooseVariation.vue";

export default {
    name: "VariationPanel",
    components: {DialogChooseVariation},
    props: {
        variationList: {
            type: Array,
            default: () => []
        }
    },
    data() {
        return {
            showDoalog: false,
            theVariation: {}
        }
    },
    methods: {
        chooseVariation(v) {
            this.theVariation = v;
            this.showDoalog = true;
        },
        onAddVariation() {
            this.variationList.push({
                name: '',
                multiple: false,
                options: []
            });
        },
        onVariationTypeChange(v) {
            v.options.forEach(o => o.selected = false);
        },
        onAddOption(v) {
            return v.options.push({
                title: '',
                price: 0,
                selected: false
            });
        },
        onRadioChange(v, i) {
            v.options.forEach((o, index) => {
                o.selected = index === i;
            });
            this.$forceUpdate();
        },
        onCheckboxChange(o) {
            o.selected = !o.selected;
            this.$forceUpdate();
        },
        onSelectedOptions(v) {
            let {name, options} = v;
            if (!this.theVariation.name) this.theVariation.name = name;

            const titles = this.theVariation.options.map(o => o.title);
            options.map(o => {
                if (titles.indexOf(o.title) === -1) {
                    o.selected = false;
                    this.theVariation.options.push(o);
                }
            });
            console.log(this.theVariation);
        }
    }
}
</script>

<style scoped>

</style>