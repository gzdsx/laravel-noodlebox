<template>
    <el-dialog :title="$t('Transactions')" closeable :visible.sync="value" :close-on-click-modal="false"
               :close-on-press-escape="false" width="60%" @close="close">
        <div>
            <el-table :data="dataList" :loading="loading" @selection-change="onSelectionChange">
                <el-table-column width="45" type="selection"/>
                <el-table-column
                        prop="created_at"
                        label="Date"
                        width="180">
                </el-table-column>
                <el-table-column
                        prop="amount"
                        label="Amount"
                        width="180">
                </el-table-column>
                <el-table-column
                        prop="note"
                        label="Notes">
                </el-table-column>
            </el-table>
            <div class="tablenav-bottom">
                <div class="table-actions">
                    <el-button size="small" type="primary" :disabled="selectionIds.length===0" @click="onBatchDelete">
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
        </div>
    </el-dialog>
</template>

<script>
import Pagination from "../mixins/Pagination";
import ApiService from "../utils/ApiService";

export default {
    name: "DialogDeliveryerTransaction",
    mixins: [Pagination],
    props: {
        value: {
            type: Boolean,
            default: false
        },
        transaction: {
            type: Object,
            default() {
                return {
                    amount: 10,
                    notes: '',
                    total: 0,
                    shipping_total: 0,
                    cash_total: 0,
                    cost_total: 0
                }
            }
        }
    },
    data() {
        return {}
    },
    watch: {
        value(newVal, oldVal) {
            if (newVal) {
                this.fetchList();
            }
        }
    },
    methods: {
        close(){
            this.$emit('input', false);
        },
        listApi() {
            return '/deliveryers/' + this.deliveryer.id + '/transactions';
        },
        onBatchDelete() {
            let {id} = this.deliveryer;
            let ids = this.selectionIds.map((d) => d.id);
            this.$confirm(this.$t('common.delete_tips'), this.$t('common.delete_confirm'), {
                type: 'warning'
            }).then(() => {
                ApiService.delete(`/deliveryers/${id}/transactions/batch`, {data: {ids}}).then(() => {
                    this.fetchList();
                });
            });
        },
    }
}
</script>

<style scoped>

</style>