<template>
    <main-layout>
        <div class="d-flex" slot="header">
            <h2 class="flex-grow-1">配送员管理</h2>
            <div>
                <el-button type="primary" size="small" @click="onShowAdd">新增配送员</el-button>
            </div>
        </div>
        <section class="page-section">
            <el-table :data="dataList" v-loading="loading" @selection-change="onSelectionChange">
                <el-table-column width="45" type="selection"/>
                <el-table-column :label="$t('user.avatar')" width="70">
                    <template slot-scope="scope">
                        <featured-image :src="scope.row.image" width="60px" height="60px" :alt="$t('user.avatar')"/>
                    </template>
                </el-table-column>
                <el-table-column :label="$t('kefu.name')">
                    <template slot-scope="scope">
                        <strong :style="{'color':scope.row.color}">{{ scope.row.name }}</strong>
                    </template>
                </el-table-column>
                <el-table-column prop="phone" width="200" :label="$t('kefu.phone')"/>
                <el-table-column prop="pos" width="200" label="POS"/>
                <el-table-column prop="base_amount" width="100" label="底金"/>
                <el-table-column prop="status" width="100" :label="$t('状态')"/>
                <el-table-column width="auto" :label="$t('common.option')" align="right" fixed="right">
                    <template slot-scope="scope">
                        <el-button size="mini" type="text" @click="onShowEdit(scope.row)">{{
                            $t('common.edit')
                            }}
                        </el-button>
                        <el-button size="mini" type="text" @click="handlerShowSattlement(scope.row)">结算</el-button>
                        <el-button size="mini" type="text" @click="handlerShowDetail(scope.row)">账户明细</el-button>
                    </template>
                </el-table-column>
            </el-table>
            <div class="tablenav-bottom">
                <div class="table-actions">
                    <el-button size="small" type="primary" :disabled="selectionIds.length===0" @click="onDelete">
                        {{ $t('common.batch_delete') }}
                    </el-button>
                </div>
                <el-pagination
                        background
                        layout="prev, pager, next, total"
                        :total="total"
                        :page-size="pageSize"
                        :current-page="page"
                        @current-change="onPageChange"
                />
            </div>
        </section>
        <el-dialog :title="$t('New Deliveryer')" closeable :visible.sync="showDialog" :close-on-click-modal="false"
                   :close-on-press-escape="false">
            <el-form size="medium" label-width="80px" style="width: 500px;">
                <el-form-item label="头像">
                    <div class="img-80" @click="showPicker=true">
                        <featured-image :src="deliveryer.image"/>
                    </div>
                </el-form-item>
                <el-form-item :label="$t('kefu.name')">
                    <el-input size="medium" v-model="deliveryer.name"/>
                </el-form-item>
                <el-form-item :label="$t('kefu.phone')">
                    <el-input size="medium" v-model="deliveryer.phone"/>
                </el-form-item>
                <el-form-item label="状态">
                    <el-radio-group v-model="deliveryer.status">
                        <el-radio label="online">Online</el-radio>
                        <el-radio label="offline">Offline</el-radio>
                    </el-radio-group>
                </el-form-item>
                <el-form-item label="POS机">
                    <el-select class="w200" v-model="deliveryer.pos" placeholder="请选择">
                        <el-option v-for="item in posMachineList" :key="item.id" :label="item.name" :value="item.name"/>
                    </el-select>
                </el-form-item>
                <el-form-item label="底金">
                    <el-input class="w200" v-model="deliveryer.base_amount"/>
                </el-form-item>
                <el-form-item label="Color">
                    <el-color-picker v-model="deliveryer.color"/>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" size="medium" class="w100" @click="onSubmit">{{ $t('common.submit') }}
                    </el-button>
                </el-form-item>
            </el-form>
        </el-dialog>
        <el-dialog :title="$t('Settlement')" closeable :visible.sync="showCheckout" :close-on-click-modal="false"
                   :close-on-press-escape="false">
            <el-form size="medium" label-width="80px" style="width: 500px;">
                <el-form-item label="金额">
                    <el-input class="w200" v-model="transaction.amount">
                        <span slot="prepend">€</span>
                    </el-input>
                </el-form-item>
                <el-form-item label="备注">
                    <el-input type="textarea" rows="3" class="w400" v-model="transaction.note"/>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" class="w100" @click="onSettlement">{{ $t('common.submit') }}
                    </el-button>
                </el-form-item>
            </el-form>
        </el-dialog>
        <media-dialog v-model="showPicker" @confirm="onSelectImage"/>
        <deliveryer-transactions :deliveryer="deliveryer" v-model="showTransactions"/>
    </main-layout>
</template>

<script>
import ApiService from "../utils/ApiService";
import Pagination from "../mixins/Pagination";
import DeliveryerTransactions from "./DeliveryerTransactions.vue";

export default {
    name: "DeliveryerList",
    components: {DeliveryerTransactions},
    mixins: [Pagination],
    data() {
        return {
            deliveryer: {},
            showDialog: false,
            showPicker: false,
            posMachineList: [],
            showCheckout: false,
            transaction: {
                amount: 10,
                note: '',
            },
            showTransactions: false
        }
    },
    methods: {
        listApi() {
            return '/deliveryers';
        },
        resetData() {
            this.deliveryer = {};
        },
        onDelete() {
            let ids = this.selectionIds.map((d) => d.id);
            this.$confirm(this.$t('common.delete_tips'), this.$t('common.delete_confirm'), {
                type: 'warning'
            }).then(() => {
                ApiService.delete('/deliveryers/batch', {data: {ids}}).then(() => {
                    this.fetchList();
                });
            });
        },
        onSubmit() {
            let {deliveryer} = this;
            if (!deliveryer.name) {
                this.$message.error(this.$t('kefu.name_required'));
                return false;
            }
            if (!deliveryer.phone) {
                this.$message.error(this.$t('kefu.phone_required'));
                return false;
            }

            if (deliveryer.id) {
                ApiService.put('/deliveryers/' + deliveryer.id, {deliveryer}).then(() => {
                    this.resetData();
                    this.fetchList();
                    this.showDialog = false;
                    this.$message.success(this.$t('kefu.updated'));
                });
            } else {
                ApiService.post('/deliveryers', {deliveryer}).then(() => {
                    this.resetData();
                    this.fetchList();
                    this.showDialog = false;
                    this.$message.success(this.$t('kefu.saved'));
                });
            }
        },
        onShowAdd() {
            this.resetData();
            this.showDialog = true;
        },
        onShowEdit(d) {
            this.deliveryer = d;
            this.showDialog = true;
        },
        onSelectImage(m) {
            this.deliveryer.image = m.src;
        },
        fetchPosMachines() {
            ApiService.get('/pos-machines').then((response) => {
                this.posMachineList = response.data.items;
            });
        },
        onSettlement() {
            let {id} = this.deliveryer;
            ApiService.post(`/deliveryers/${id}/transactions`, this.transaction).then(() => {
                this.fetchList();
                this.showCheckout = false;
                this.$message.success('结算成功');
            });
        },
        handlerShowSattlement(d) {
            this.deliveryer = d;
            this.showCheckout = true;
        },
        handlerShowDetail(d) {
            this.deliveryer = d;
            this.showTransactions = true;
        }
    },
    mounted() {
        this.fetchList();
        this.fetchPosMachines();
    },
}
</script>

<style scoped>

</style>
