<template>
    <div class="sku-panel">
        <vuedraggable class="variation-list__sortable" v-model="variationList" @change="onSortChange"
                      draggable=".sku-draggable"
                      handle=".sku-mover">
            <div class="sku-classify sku-draggable" v-for="(v,index) in variationList" :key="index">
                <div class="sku-classify-header sku-mover">
                    <div class="sku-classify-attribute">{{$t('variations.name')}}:</div>
                    <div class="sku-classify-select">
                        <el-input size="medium" v-model="v.name"/>
                        <el-button size="medium" type="text" @click="chooseVariation(v)">
                            {{$t('variations.select_commonly')}}
                        </el-button>
                    </div>
                    <div class="flex"></div>
                    <div class="el-icon-error sku-classify-del" @click="variationList.splice(index,1)"></div>
                </div>
                <div class="sku-classify-content">
                    <div v-if="v.options.length">
                        <div class="variation-list">
                            <div class="variation-list__item">
                                <div class="col-label">{{$t('variations.option_name')}}</div>
                                <div class="col-price">{{$t('variations.price')}}</div>
                                <div class="col-price">{{$t('variations.default_select')}}</div>
                            </div>
                            <vuedraggable class="variation-list__sortable" v-model="v.options" draggable=".draggable"
                                          handle=".mover">
                                <div class="variation-list__item draggable" v-for="(o,i) in v.options" :key="i">
                                    <div class="col-label">
                                        <el-input size="medium" v-model="o.title"/>
                                    </div>
                                    <div class="col-price">
                                        <el-input size="medium" v-model="o.price"/>
                                    </div>
                                    <div class="col-price">
                                        <label class="el-radio">
                                            <div class="el-radio__input" :class="{'is-checked':o.selected}">
                                                <span class="el-radio__inner"></span>
                                                <input type="radio" class="el-radio__original" :checked="o.selected"
                                                       @click="onRadioChange(v,i)"/>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="col-remove">
                                        <i class="el-icon-error" @click="v.options.splice(i,1)"></i>
                                    </div>
                                    <div class="col-move">
                                        <svg t="1718194441474" class="mover" viewBox="0 0 1024 1024" version="1.1"
                                             xmlns="http://www.w3.org/2000/svg" p-id="6929" width="24" height="24">
                                            <path d="M605.090909 257.93939367h139.636364v139.636364h-139.636364zM605.090909 630.30303067h139.636364v139.636363h-139.636364zM325.818182 257.93939367h139.636363v139.636364H325.818182zM325.818182 630.30303067h139.636363v139.636363H325.818182zM884.363636 257.93939367h139.636364v139.636364h-139.636364zM884.363636 630.30303067h139.636364v139.636363h-139.636364z"
                                                  p-id="6930" fill="#8a8a8a"></path>
                                        </svg>
                                    </div>
                                </div>
                            </vuedraggable>
                        </div>
                    </div>
                    <div>
                        <el-button class="sku-item-add" size="small" icon="el-icon-plus"
                                   @click="onAddOption(v)">
                            {{$t('variations.add_option')}}
                        </el-button>
                    </div>
                </div>
            </div>
        </vuedraggable>
        <div class="sku-operate-buttons">
            <el-button size="small" icon="el-icon-plus" @click="onAddVariation">
                {{ $t('variations.addnew')}}
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
        value: {
            type: Array,
            default: () => []
        }
    },
    data() {
        return {
            showDoalog: false,
            theVariation: {},
            variationList: []
        }
    },
    watch: {
        value(val) {
            this.variationList = val;
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
        onSelectedOptions(v) {
            let {name, options} = v;
            if (!this.theVariation.name) this.theVariation.name = name;

            const titles = this.theVariation.options.map(o => o.title);
            options.map(o => {
                if (titles.indexOf(o.title) === -1) {
                    o.selected = false;
                    this.theVariation.options.push({...o});
                }
            });
        },
        onSortChange() {
            this.$emit('input', this.variationList);
        }
    }
}
</script>

<style scoped>

</style>