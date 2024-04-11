<template>
    <div class="sku-panel">
        <div class="sku-classify-content" style="padding: 0;">
            <div v-if="additionalOptions.length">
                <div class="variation-list">
                    <div class="variation-list__item">
                        <div class="col-label">选项名称</div>
                        <div class="col-price">价格</div>
                        <div class="col-price">默认选择</div>
                    </div>
                    <div class="variation-list__item" v-for="(o,i) in additionalOptions" :key="i">
                        <div class="col-label">
                            <el-input size="medium" v-model="o.title"/>
                        </div>
                        <div class="col-price">
                            <el-input size="medium" v-model="o.price"/>
                        </div>
                        <div class="col-price">
                            <el-checkbox v-model="o.selected"/>
                        </div>
                        <div>
                            <i class="el-icon-error" @click="additionalOptions.splice(i,1)"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <el-button class="sku-item-add" size="small" icon="el-icon-plus"
                           @click="onAddOption">
                    添加选项
                </el-button>
                <el-button size="medium" type="text" @click="showDoalog=true">
                    选择常用选项
                </el-button>
            </div>
        </div>
        <dialog-choose-variation @select="onSelectedOptions" v-model="showDoalog"/>
    </div>
</template>

<script>
import DialogChooseVariation from "./DialogChooseVariation.vue";

export default {
    name: "AdditionalOptionsPanel",
    components: {DialogChooseVariation},
    props: {
        additionalOptions: {
            type: Array,
            default: () => []
        }
    },
    data() {
        return {
            showDoalog: false
        }
    },
    methods: {
        onAddOption() {
            return this.additionalOptions.push({
                title: '',
                price: 0,
                selected: false
            });
        },
        onSelectedOptions(v) {
            let {name, options} = v;
            const titles = this.additionalOptions.map(o => o.title);
            options.map(o => {
                if (titles.indexOf(o.title) === -1) {
                    o.selected = false;
                    this.additionalOptions.push({...o});
                }
            });
        }
    }
}
</script>

<style scoped>

</style>