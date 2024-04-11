<template>
    <div class="sku-panel">
        <div class="sku-classify" v-for="(attr,index) in attributeList" :key="index">
            <div class="sku-classify-header">
                <div class="sku-classify-attribute">型号分类:</div>
                <div class="sku-classify-select">
                    <el-input size="medium" @input="renderTable" v-model="attr.name"/>
                    <el-button size="medium" type="text" @click="chooseAttribute(attr)">选择常用型号</el-button>
                </div>
                <div class="flex"></div>
                <div class="el-icon-error sku-classify-del" @click="onDelAttr(index)"></div>
            </div>
            <div class="sku-classify-content">
                <div class="sku-sort-types" v-if="attr.options.length">
                    <div class="sku-type" v-for="(option,idx) in attr.options" :key="idx">
                        <span class="sku-type-value">{{ option.value }}</span>
                        <span class="el-icon-error sku-type-del" @click="onDelOption(attr,idx)"></span>
                    </div>
                </div>
                <div>
                    <el-button class="sku-item-add" size="small" icon="el-icon-plus" @click="onAddOption(attr)">
                        添加型号
                    </el-button>
                </div>
            </div>
        </div>
        <div class="sku-operate-buttons" v-if="attributeList.length<3">
            <el-button size="small" icon="el-icon-plus" @click="onAddAttr">
                添加型号分类
            </el-button>
        </div>
        <div class="sku-table-wrapper" v-if="skuList.length>0">
            <table class="sku-table">
                <thead>
                <tr>
                    <th v-for="(name,index) in attrNames" :key="index">{{ name }}</th>
                    <th class="col-120">
                        <div class="h-title">
                            <i class="star">*</i>
                            <span>价格</span>
                        </div>
                        <div class="h-input">
                            <el-input size="small" type="number" v-model="fillPrice" @blur="onFillPrice"/>
                        </div>
                    </th>
                    <th class="col-120" v-if="pinable">
                        <div class="h-title">
                            <i class="star">*</i>
                            <span>拼团价</span>
                        </div>
                        <div class="h-input">
                            <el-input size="small" type="number" v-model="fillPinPrice" @blur="onFillPinPrice"/>
                        </div>
                    </th>
                    <th class="col-120">
                        <div class="h-title">
                            <i class="star">*</i>
                            <span>库存</span>
                        </div>
                        <div class="h-input">
                            <el-input size="small" type="number" v-model="fillStock" @blur="onFillStock"/>
                        </div>
                    </th>
                    <th class="col-120">
                        <div class="h-title">
                            <span>商家编码</span>
                        </div>
                        <div class="h-input">
                            <el-input size="small" v-model="fillCode" @blur="onFillCode"/>
                        </div>
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(sku,i) in skuList">
                    <td
                            v-for="(op,j) in attrOptions[i]"
                            :rowspan="rowSpans[j]"
                            v-if="showColumn(i,j)">{{ op.value }}
                    </td>
                    <td>
                        <el-input size="small" type="number" @change="handleSkuChange" v-model="sku.price"/>
                    </td>
                    <td v-if="pinable">
                        <el-input size="small" type="number" @change="handleSkuChange" v-model="sku.pin_price"/>
                    </td>
                    <td>
                        <el-input size="small" type="number" @change="handleSkuChange" v-model="sku.stock"/>
                    </td>
                    <td>
                        <el-input size="small" type="text" @change="handleSkuChange" v-model="sku.code"/>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <el-dialog
                title="添加型号"
                width="400px"
                closeable
                :visible.sync="showDialog"
                :close-on-click-modal="false"
                :close-on-press-escape="false"
        >
            <div class="d-flex column-gap-10">
                <el-input v-model="newOptionValue"/>
                <el-button type="primary" @click="createOption">创建</el-button>
            </div>
        </el-dialog>
        <dialog-choose-attribute @select="onSelectAttribute" v-model="showAttrDialog"/>
    </div>
</template>

<script>
import DialogChooseAttribute from "./DialogChooseAttribute.vue";

export default {
    name: "SkuPanel",
    components: {DialogChooseAttribute},
    data() {
        return {
            skuList: [],
            attrList: [],
            attributeList: [],
            attrNames: [],
            attrOptions: [],
            rowSpans: [],
            showCount: [],
            attribute: {name: '', options: []},
            newOptionValue: '',
            fillPrice: '',
            fillStock: '',
            fillCode: '',
            fillPinPrice: '',
            showDialog: false,
            showAttrDialog: false,
        }
    },
    props: {
        defaultAttributes: {
            type: Array,
            default: function () {
                return []
            }
        },
        defaultSkus: {
            type: Object,
            default: function () {
                return {}
            }
        },
        shop_id: {
            type: [String, Number],
            default: 0
        },
        pinable: {
            type: Boolean,
            default: false
        }
    },
    watch: {
        defaultAttributes(val) {
            this.attributeList = val;
        },
        skuList() {
            this.handleSkuChange();
        },
        attrOptions() {
            this.generateSkus();
            this.handleSkuChange();
        }
    },
    methods: {
        onAddAttr() {
            if (this.attributeList.length < 3) {
                this.attributeList.push({
                    id: 0,
                    name: '',
                    options: []
                });
            }
        },
        onDelAttr(index) {
            this.attributeList.splice(index, 1);
        },
        chooseAttribute(attr) {
            this.attribute = attr;
            this.showAttrDialog = true;
        },
        onAddOption(attr) {
            this.attribute = attr;
            this.showDialog = true;
        },
        createOption() {
            const {newOptionValue, attribute} = this;
            if (!newOptionValue) return;
            const values = attribute.options.map(o => o.value);
            if (values.indexOf(newOptionValue) === -1) {
                attribute.options.push({
                    id: 0,
                    value: newOptionValue
                });
                this.newOptionValue = '';
                this.renderTable();
                this.showDialog = false;
            }
        },
        onSelectAttribute(v) {
            const {attribute} = this;
            const values = attribute.options.map(o => o.value);
            v.options.map(o => {
                if (values.indexOf(o.value) === -1) {
                    attribute.options.push(o);
                }
            });

            if (!attribute.name) {
                attribute.name = v.name;
            }

            this.renderTable();
            this.showAttrDialog = false;
        },
        onDelOption(attr, i) {
            attr.options.splice(i, 1);
            this.renderTable();
        },
        renderTable() {
            let rowCount = [];
            let attrList = [];
            let attrNames = [];
            let attrOptions = [];
            this.attributeList.map((attr) => {
                if (attr.name) {
                    let options = [];
                    attr.options.map(function (o) {
                        if (o.value) options.push(o);
                    });

                    if (options.length > 0) {
                        attrNames.push(attr.name);
                        attrOptions.push(options);
                        rowCount.push(options.length);
                        attr.options = options;
                        attrList.push(attr);
                    }
                }
            });

            let rowSpans = [];
            let showCount = [];
            for (let i = 0; i < rowCount.length; i++) {
                let subRowCount = rowCount.slice(i + 1, rowCount.length);
                rowSpans.push(subRowCount.reduce(function (a, b) {
                    return a * b;
                }, 1));

                let subAttrCount = rowCount.slice(0, i + 1);
                let rowspanItem = subAttrCount.reduce(function (a, b) {
                    return a * b;
                }, 1);
                showCount.push(rowspanItem);
            }
            this.rowSpans = rowSpans;
            this.showCount = showCount;
            this.attrNames = attrNames;
            this.attrList = attrList;
            if (attrOptions.length > 0) {
                this.attrOptions = this.combine(attrOptions.reverse());
            } else {
                this.attrOptions = [];
            }
        },
        generateSkus() {
            let skuList = [];
            this.attrOptions.map((row, i) => {
                let title = row.map((r) => r.value).join(',');
                let properties = row.map((r) => r.id).join('-');
                if (this.defaultSkus[properties]) {
                    skuList.push(this.defaultSkus[properties]);
                } else {
                    skuList.push({
                        id: 0,
                        price: '',
                        pin_price: '',
                        stock: '',
                        code: '',
                        image: '',
                        title,
                        properties
                    });
                }
            });

            this.skuList = skuList;
            this.handleSkuChange();
        },
        handleSkuChange() {
            this.$emit('change', {
                skus: this.skuList,
                attrs: this.attrList
            });
        },
        showColumn(row, col) {
            const maxCount = this.showCount[this.showCount.length - 1]; // 最多行的一列（即最后一列）
            if (col < this.showCount.length - 1 && row !== 0) {
                // 在非第一行也不是最后一列只有在满足次条件才能显示
                return row % (maxCount / this.showCount[col]) === 0;
            } else {
                // 第一行或最后一列都是直接显示即可
                return true;
            }
        },
        combine(arr) {
            var r = [];
            (function f(t, a, n) {
                if (n === 0) return r.push(t);
                for (var i = 0; i < a[n - 1].length; i++) {
                    f(t.concat(a[n - 1][i]), a, n - 1);
                }
            })([], arr, arr.length);
            return r;
        },
        onFillPrice(e) {
            const value = e.target.value;
            if (!value) return;
            this.skuList.forEach((sku) => {
                sku.price = value;
            });
            this.handleSkuChange();
        },
        onFillPinPrice(e) {
            const value = e.target.value;
            if (!value) return;
            this.skuList.forEach((sku) => {
                sku.pin_price = value;
            });
            this.handleSkuChange();
        },
        onFillStock(e) {
            const value = e.target.value;
            if (!value) return;
            this.skuList.forEach((sku) => {
                sku.stock = value;
            });
            this.handleSkuChange();
        },
        onFillCode(e) {
            const value = e.target.value;
            if (!value) return;
            this.skuList.forEach((sku) => {
                sku.code = value;
            });
            this.handleSkuChange();
        }
    },
    mounted() {
        this.attributeList = this.defaultAttributes;
    }
}
</script>

<style scoped>

</style>
