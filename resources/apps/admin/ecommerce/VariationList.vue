<template>
    <main-layout>
        <div class="d-flex" slot="header">
            <h2 class="flex-grow-1">{{$t('variations.page_title')}}</h2>
            <div class="header-right">
                <el-button type="primary" size="small" @click="onShowAdd">{{$t('variations.addnew')}}</el-button>
            </div>
        </div>

        <section class="page-section">
            <el-table :data="dataList" v-loading="loading" @selection-change="onSelectionChange">
                <el-table-column width="40" type="selection"/>
                <el-table-column :label="$t('variations.name')" width="200">
                    <template slot-scope="scope">
                        <strong>{{ scope.row.name }}</strong>
                    </template>
                </el-table-column>
                <el-table-column :label="$t('variations.options')">
                    <template slot-scope="scope">
                        <span>{{ showOptions(scope.row) }}</span>
                    </template>
                </el-table-column>
                <el-table-column :label="$t('common.edit')" width="100" align="right">
                    <template slot-scope="scope">
                        <a @click="onShowEdit(scope.row)">{{ $t('common.edit') }}</a>
                    </template>
                </el-table-column>
            </el-table>
            <div class="tablenav tablenav-bottom">
                <div class="table-actions">
                    <el-button size="small"
                               type="primary"
                               :disabled="selectionIds.length === 0"
                               @click="batchDelete"
                               v-if="userInfo.capability==='administrator'"
                    >
                        {{ $t('common.batch_delete') }}
                    </el-button>
                </div>
                <el-pagination
                    background
                    layout="prev, pager, next,total"
                    :total="total"
                    :page-size="pageSize"
                    :current-page="page"
                    @current-change="onPageChange"
                />
            </div>
        </section>

        <el-dialog
                :title="$t('variations.addnew')"
                :visible.sync="showDialog"
                :close-on-click-modal="false"
                :close-on-press-escape="false"
                closeable
        >
            <el-form size="medium" label-width="60px">
                <el-form-item :label="$t('variations.name')">
                    <el-input class="w300" v-model="variation.name"/>
                </el-form-item>
                <el-form-item :label="$t('common.option')">
                    <div class="product-attribute-wrapper" v-if="variation.options.length">
                        <div class="product-attribute-row">
                            <div class="col-label">{{$t('variations.name')}}</div>
                            <div class="col-price">{{$t('common.price')}}</div>
                        </div>
                        <div class="product-attribute-row" v-for="(o,i) in variation.options" :key="i">
                            <div class="col-label">
                                <el-input v-model="o.title"/>
                            </div>
                            <div class="col-price">
                                <el-input v-model="o.price"/>
                            </div>
                            <div>
                                <i class="el-icon-error icon-remove" @click="variation.options.splice(i,1)"></i>
                            </div>
                        </div>
                    </div>
                    <el-button size="small" class="product-attribute-add-item" icon="el-icon-plus"
                               @click="addOption">{{$t('variations.addoption')}}
                    </el-button>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="onSubmit">{{$t('common.confirm')}}</el-button>
                </el-form-item>
            </el-form>
        </el-dialog>
    </main-layout>
</template>

<script>
import ApiService from "../utils/ApiService";
import Pagination from "../mixins/Pagination";

export default {
    name: "VariationList",
    mixins: [Pagination],
    data() {
        return {
            variation: {name: '', options: []},
            showDialog: false,
            selectionIds: []
        }
    },
    computed: {
        userInfo() {
            return this.$store.state.userInfo;
        },
    },
    methods: {
        listApi() {
            return '/products/variations';
        },
        onShowAdd() {
            this.resetData();
            this.showDialog = true;
        },
        onShowEdit(v) {
            this.variation = {...v};
            this.showDialog = true;
        },
        batchDelete() {
            let ids = this.selectionIds.map((d) => d.id);
            this.$confirm(this.$t('common.delete_tips'), this.$t('common.delete_confirm'), {
                type: 'warning'
            }).then(() => {
                ApiService.delete('/products/variations/batch', {data: {ids}}).then(() => {
                    this.fetchList();
                });
            });
        },
        onSubmit() {
            let {variation} = this;
            if (!variation.name) {
                this.$message.error('Name is required!');
                return false;
            }

            if (variation.id) {
                ApiService.put('/products/variations/' + variation.id, variation).then(() => {
                    this.resetData();
                    this.fetchList();
                    this.showDialog = false;
                    this.$message.success('Variation updated!');
                }).catch(reason => {
                    this.$message.error(reason.message);
                });
            } else {
                ApiService.post('/products/variations', variation).then(() => {
                    this.resetData();
                    this.fetchList();
                    this.showDialog = false;
                    this.$message.success('Variation created!');
                }).catch(reason => {
                    this.$message.error(reason.message);
                });
            }
        },
        resetData() {
            this.variation = {
                id: 0,
                name: '',
                options: []
            }
        },
        addOption() {
            this.variation.options.push({id: 0, title: '', price: 0});
        },
        showOptions(v) {
            return v.options.map(o => o.title).join(', ');
        }
    },
    mounted() {
        this.resetData();
        this.fetchList();
    },
}
</script>

<style scoped>

</style>
