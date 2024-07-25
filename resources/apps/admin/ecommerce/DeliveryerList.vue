<template>
    <main-layout>
        <div class="d-flex" slot="header">
            <h2 class="flex-grow-1">{{$t('deliveryer.title')}}</h2>
            <div>
                <el-button type="primary" size="small" @click="onShowAdd">{{$t('deliveryer.addnew')}}</el-button>
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
                <el-table-column :label="$t('deliveryer.name')">
                    <template slot-scope="scope">
                        <strong :style="{'color':scope.row.color}">{{ scope.row.name }}</strong>
                    </template>
                </el-table-column>
                <el-table-column prop="phone" width="200" :label="$t('user.phone')"/>
                <el-table-column prop="pos" width="200" label="POS">
                    <template slot-scope="scope">
                        <div class="column-tags">
                            <el-tag size="small" v-for="(mac,index) in scope.row.pos_machines" :key="mac.id">
                                {{ mac.name }}
                            </el-tag>
                        </div>
                    </template>
                </el-table-column>
                <el-table-column prop="base_amount" width="100" :label="$t('deliveryer.base_amount')"/>
                <el-table-column prop="status" width="100" :label="$t('status')"/>
                <el-table-column width="100" :label="$t('common.option')" align="right" fixed="right">
                    <template slot-scope="scope">
                        <el-button size="mini" type="text" @click="onShowEdit(scope.row)">
                            {{ $t('common.edit') }}
                        </el-button>
                    </template>
                </el-table-column>
            </el-table>
            <div class="tablenav-bottom">
                <div class="table-actions">
                    <el-button size="small" type="primary"
                               :disabled="selectionIds.length===0"
                               @click="onDelete" v-if="$store.getters.userInfo.capability==='administrator'">
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
            <el-form size="medium" label-width="140px" style="width: 500px;">
                <el-form-item :label="$t('user.avatar')">
                    <div class="img-80" @click="showPicker=true">
                        <featured-image :src="deliveryer.image"/>
                    </div>
                </el-form-item>
                <el-form-item :label="$t('deliveryer.name')">
                    <el-input size="medium" v-model="deliveryer.name"/>
                </el-form-item>
                <el-form-item :label="$t('kefu.phone')">
                    <el-input size="medium" v-model="deliveryer.phone"/>
                </el-form-item>
                <el-form-item :label="$t('common.status')">
                    <el-radio-group v-model="deliveryer.status">
                        <el-radio label="online">Online</el-radio>
                        <el-radio label="offline">Offline</el-radio>
                    </el-radio-group>
                </el-form-item>
                <el-form-item :label="$t('deliveryer.pos_machines')">
                    <el-checkbox-group v-model="deliveryer.pos_machines">
                        <el-checkbox v-for="item in posMachineList" :key="item.id" :label="item">{{ item.name }}
                        </el-checkbox>
                    </el-checkbox-group>
                </el-form-item>
                <el-form-item :label="$t('deliveryer.base_amount')">
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
        <media-dialog v-model="showPicker" @confirm="onSelectImage"/>
    </main-layout>
</template>

<script>
import ApiService from "../utils/ApiService";
import Pagination from "../mixins/Pagination";
import DialogDeliveryerOrders from "./DialogDeliveryerOrders.vue";
import DialogDeliveryerTransaction from "./DialogDeliveryerTransaction.vue";

export default {
    name: "DeliveryerList",
    components: {DialogDeliveryerTransaction, DialogDeliveryerOrders},
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
                total: 0,
                shipping_total: 0,
                cash_total: 0,
                cost_total: 0
            },
            showTransactions: false,
            showOrders: false
        }
    },
    methods: {
        listApi() {
            return '/deliveryers';
        },
        resetData() {
            this.deliveryer = {
                name: '',
                phone: '',
                image: 'https://www.noodlebox.ie/storage/image/2024/06/xCBIaqkVWDboCg4CVz2hy2X9TOchd0hpD8WNjWZY.png',
                status: 'online',
                base_amount: 0,
                color: '#000',
                pos_machines: []
            };
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
                ApiService.put('/deliveryers/' + deliveryer.id, deliveryer).then(() => {
                    this.resetData();
                    this.fetchList();
                    this.showDialog = false;
                    this.$message.success(this.$t('kefu.updated'));
                });
            } else {
                ApiService.post('/deliveryers', deliveryer).then(() => {
                    this.resetData();
                    this.fetchList();
                    this.showDialog = false;
                    this.$message.success(this.$t('kefu.saved'));
                });
            }
        },
        onShowAdd() {
            this.resetData();
            this.fetchPosMachines(() => {
                this.showDialog = true;
            });
        },
        onShowEdit(d) {
            this.deliveryer = d;
            this.fetchPosMachines(() => {
                this.showDialog = true;
            });
        },
        onSelectImage(m) {
            this.deliveryer.image = m.src;
        },
        fetchPosMachines(cb) {
            ApiService.get('/pos-machines?status=idle&is_cashier=0').then((response) => {
                this.posMachineList = this.deliveryer.pos_machines.concat(response.data.items);
                if (cb) cb();
            });
        },
        onSettlement() {
            let {id} = this.deliveryer;
            let {total, note} = this.transaction;
            ApiService.post(`/deliveryers/${id}/transactions`, {amount: total, note}).then(() => {
                this.fetchList();
                this.showCheckout = false;
                this.$message.success('结算成功');
            });
        },
        handleShowSattlement(d) {
            this.deliveryer = d;
            ApiService.get(`/deliveryers/${d.id}/caculate`).then(response => {
                this.transaction = {
                    ...this.transaction,
                    ...response.data
                }
                this.showCheckout = true;
            }).catch(reason => {
                this.$message.error(reason.message);
            }).finally(() => {

            });
        },
        handleShowDetail(d) {
            this.deliveryer = d;
            this.showOrders = true;
        },
        handleShowOrders() {
            this.showOrders = true;
        }
    },
    mounted() {
        this.fetchList();
    },
}
</script>

<style scoped>

</style>
