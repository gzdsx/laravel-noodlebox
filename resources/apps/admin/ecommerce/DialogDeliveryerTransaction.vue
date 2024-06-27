<template>
    <el-dialog :title="$t('Deliveryer Transaction')" closeable :visible.sync="value" :close-on-click-modal="false"
               :close-on-press-escape="false" width="60%" @close="close">
        <el-descriptions title="" direction="vertical" :column="4" border>
            <el-descriptions-item label="POS底金">{{ transaction.base_amount }}</el-descriptions-item>
            <el-descriptions-item label="配送费">{{ transaction.shipping_total }}</el-descriptions-item>
            <el-descriptions-item label="现金收入">{{ transaction.cash_total }}</el-descriptions-item>
            <el-descriptions-item label="在线收入">{{ transaction.online_total }}</el-descriptions-item>
            <el-descriptions-item label="卡机收入">{{ transaction.card_total }}</el-descriptions-item>
            <el-descriptions-item label="Cost Total">{{ transaction.cost_total }}</el-descriptions-item>
            <el-descriptions-item label="应交金额">{{ transaction.total }}</el-descriptions-item>
        </el-descriptions>
        <el-form size="medium" label-position="top" style="margin-top:20px;">
            <el-form-item label="Status">
                <el-select v-model="transaction.status">
                    <el-option label="已结款" value="settled"/>
                    <el-option label="未结款" value="pending"/>
                </el-select>
            </el-form-item>
            <el-form-item label="备注">
                <el-input v-model="transaction.notes" type="textarea" rows="3" class="w500" placeholder=""/>
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
                    status:'pending'
                }
            }
        }
    },
    data() {
        return {}
    },
    methods: {
        close() {
            this.$emit('input', false);
        },
        handleSubmit() {
            let {status,notes,id} = this.transaction;
            ApiService.put('/deliveryers/transactions/'+id, {status,notes}).then(() => {
                this.$message.success('结算成功');
                this.$emit('input', false);
            });
        }
    }
}
</script>

<style scoped>

</style>