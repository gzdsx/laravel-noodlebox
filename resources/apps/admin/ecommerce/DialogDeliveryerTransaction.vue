<template>
    <el-dialog :title="$t('Deliveryer Transaction')" closeable :visible.sync="value" :close-on-click-modal="false"
               :close-on-press-escape="false" width="60%" @close="close">
        <el-table :data="orders" border>
            <el-table-column :label="$t('order.no')" prop="short_code"/>
            <el-table-column :label="$t('order.shipping_zone')" prop="shipping_line.zone_title"/>
            <el-table-column :label="$t('order.shipping_total')" prop="shipping_total"/>
            <el-table-column :label="$t('Cost F')" prop="meta_data.cost_total"/>
            <el-table-column :label="$t('order.total')" prop="total"/>
            <el-table-column :label="$t('order.payment_method')" prop="payment_method"/>
        </el-table>
        <el-descriptions title="" direction="vertical" :column="4" border>
            <el-descriptions-item :label="$t('transaction.base_amount')">{{ transaction.base_amount }}</el-descriptions-item>
            <el-descriptions-item :label="$t('transaction.shipping_total')">{{ transaction.shipping_total }}</el-descriptions-item>
            <el-descriptions-item :label="$t('transaction.cash_total')">{{ transaction.cash_total }}</el-descriptions-item>
            <el-descriptions-item :label="$t('transaction.online_total')">{{ transaction.online_total }}</el-descriptions-item>
            <el-descriptions-item :label="$t('transaction.card_total')">{{ transaction.card_total }}</el-descriptions-item>
            <el-descriptions-item label="Cost Total">{{ transaction.cost_total }}</el-descriptions-item>
            <el-descriptions-item :label="$t('transaction.total')">{{ transaction.total }}</el-descriptions-item>
        </el-descriptions>
        <el-form size="medium" label-position="top" style="margin-top:20px;">
            <el-form-item label="Status">
                <el-select v-model="transaction.status">
                    <el-option :label="$t('transaction.status_options.settled')" value="settled"/>
                    <el-option :label="$t('transaction.status_options.pending')" value="pending"/>
                </el-select>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="handleSubmit">Submit</el-button>
            </el-form-item>
        </el-form>
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
                    base_amount: 10,
                    notes: '',
                    total: 0,
                    shipping_total: 0,
                    cash_total: 0,
                    card_total: 0,
                    cost_total: 0,
                    status:'pending',
                }
            }
        }
    },
    data() {
        return {
            orders:[]
        }
    },
    watch: {
        transaction() {
            this.loadOrders();
        }
    },
    methods: {
        close() {
            this.$emit('input', false);
        },
        handleSubmit() {
            let {status,notes,id} = this.transaction;
            ApiService.put('/deliveryers/transactions/'+id, {status,notes}).then(() => {
                this.$message.success('Submitted Success');
                this.$emit('input', false);
            });
        },
        loadOrders() {
            ApiService.get('/deliveryers/'+this.transaction.deliveryer_id+'/orders').then(response => {
                this.orders = response.data.items;
            });
        },
    }
}
</script>

<style scoped>

</style>