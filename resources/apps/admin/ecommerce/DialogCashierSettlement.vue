<template>
    <el-dialog
            title="收银机结算"
            width="75%"
            :visible="value"
            :close-on-click-modal="false"
            :close-on-press-escape="false"
            append-to-body
            closeable
            @close="$emit('input', false)"
    >
        <el-descriptions title="" direction="vertical" :column="4" border>
            <el-descriptions-item label="底金">{{ settlement.pos_base_amount }}</el-descriptions-item>
            <el-descriptions-item label="配送费">{{ settlement.shipping_total }}</el-descriptions-item>
            <el-descriptions-item label="现金支付">{{ settlement.cash_total }}</el-descriptions-item>
            <el-descriptions-item label="在线支付">{{ settlement.online_total }}</el-descriptions-item>
            <el-descriptions-item label="卡支付">{{ settlement.card_total }}</el-descriptions-item>
            <el-descriptions-item label="总计收入">{{ settlement.total }}</el-descriptions-item>
            <el-descriptions-item label="退款">{{ settlement.refund_total }}</el-descriptions-item>
            <el-descriptions-item label="实际现金收入">{{ settlement.cash_profit_total }}</el-descriptions-item>
        </el-descriptions>
        <el-form size="medium" label-position="top" style="margin-top:20px;">
            <el-form-item label="备注">
                <el-input v-model="notes" type="textarea" rows="3" class="w500" placeholder=""/>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="handleSubmit">Submit</el-button>
            </el-form-item>
        </el-form>
    </el-dialog>
</template>

<script>
import transaction from "../trade/Transaction.vue";
import ApiService from "../utils/ApiService";

export default {
    name: "DialogCashierSettlement",
    computed: {
        transaction() {
            return transaction
        }
    },
    props: {
        value: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            settlement: {
                pos_base_amount: 0,
                shipping_total: 0,
                cash_total: 0,
                online_total: 0,
                card_total: 0,
                cost_total: 0,
                total: 0,
                refund_total: 0,
                cash_profit_total: 0
            },
            notes: ''
        }
    },
    watch:{
        value(val) {
            if (val) {
                this.fetchSettlement();
            }
        }
    },
    methods: {
        handleSubmit() {
            ApiService.post('/cashier/transactions', {
                notes: this.notes
            }).then(() => {
                this.$message.success('结算成功');
                this.$emit('input', false);
            });
        },
        fetchSettlement() {
            ApiService.get('/cashier/calculate').then(response => {
                this.settlement = {
                    ...this.settlement,
                    ...response.data
                };
            });
        }
    },
    mounted() {

    }
}
</script>

<style scoped>

</style>