<template>
    <el-dialog :title="$t('Deliveryer Transaction')" closeable :visible.sync="visible" :close-on-click-modal="false"
               :close-on-press-escape="false" width="60%" @close="close">
        <el-descriptions title="" direction="vertical" :column="5" border>
            <el-descriptions-item :label="$t('transaction.base_amount')">{{
                    transaction.base_amount
                }}
            </el-descriptions-item>
            <el-descriptions-item :label="$t('transaction.shipping_total')">{{
                    transaction.shipping_total
                }}
            </el-descriptions-item>
            <el-descriptions-item :label="$t('transaction.online_total')">{{
                    transaction.online_total
                }}
            </el-descriptions-item>
            <el-descriptions-item :label="$t('transaction.card_total')">{{
                    transaction.card_total
                }}
            </el-descriptions-item>
            <el-descriptions-item :label="$t('transaction.cash_total')">{{
                    transaction.cash_total
                }}
            </el-descriptions-item>
            <el-descriptions-item :label="$t('transaction.cost_total')">
                {{ transaction.cost_total }}
            </el-descriptions-item>
            <el-descriptions-item :label="$t('transaction.refund_total')">{{
                    transaction.refund_total
                }}
            </el-descriptions-item>
            <el-descriptions-item :label="$t('transaction.actual_total')">{{
                    transaction.actual_total
                }}
            </el-descriptions-item>
            <el-descriptions-item :label="$t('transaction.total')">{{
                    transaction.total
                }}
            </el-descriptions-item>
            <el-descriptions-item :label="$t('transaction.net_total')">{{
                    transaction.net_total
                }}
            </el-descriptions-item>
        </el-descriptions>
        <el-form size="medium" :inline="true" style="margin-top:20px;" v-if="billing.status!=='settled'">
            <el-form-item>
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
import ApiService from "../utils/ApiService";

export default {
    name: "DialogCashierTransaction",
    props: {
        value: {
            type: Boolean,
            default: false
        },
        billing: {
            type: Object,
            default() {
                return {}
            }
        }
    },
    data() {
        return {
            orders: [],
            visible: false,
            transaction: {
                base_amount: 10,
                notes: '',
                total: 0,
                shipping_total: 0,
                cash_total: 0,
                card_total: 0,
                cost_total: 0,
                status: 'pending',
            }
        }
    },
    watch: {
        value(newVal, oldVal) {
            this.visible = newVal;
        },
        billing(newVal, oldVal) {
            this.transaction = {
                ...this.transaction,
                ...newVal
            }
        }
    },
    methods: {
        close() {
            this.$emit('input', false);
        },
        handleSubmit() {
            let {status, id} = this.transaction;
            ApiService.put(`/cashier/transactions/${id}`, {status}).then(() => {
                this.$message.success('Submitted Success');
                this.$emit('input', false);
                this.$emit('change');
            });
        },
    }
}
</script>

<style scoped>

</style>