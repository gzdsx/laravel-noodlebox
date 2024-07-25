<script>
import ApiService from "../utils/ApiService";

export default {
    name: "CashierBilling",
    data() {
        return {
            billing: {
                base_amount: 0,
                shipping_total: 0,
                cash_total: 0,
                online_total: 0,
                card_total: 0,
                cost_total: 0,
                total: 0,
                refund_total: 0,
                actual_total: 0,
                pos_balance:0,
                status: 'pending',
                notes: ''
            },
        }
    },
    methods: {
        fetchData() {
            ApiService.get('cashier/transactions/billing').then(response => {
                this.billing = {
                    ...this.billing,
                    ...response.data
                };
            });
        },
        handleSubmit() {
            const {status, pos_balance} = this.billing;
            ApiService.post('/cashier/transactions', {
                status,
                pos_balance
            }).then(() => {
                this.$message.success('Submitted Success');
                this.fetchData();
            }).catch(reason => {
                this.$message.error(reason.message);
            }).finally(() => {

            });
        }
    },
    mounted() {
        this.fetchData();
    }
}
</script>

<template>
    <main-layout>
        <div class="d-flex justify-content-between" slot="header">
            <h2>Cashier Report</h2>
            <router-link to="/cashier/transactions">
                <el-button size="small" type="primary">Histories</el-button>
            </router-link>
        </div>
        <section class="page-section">
            <el-descriptions title="" direction="vertical" :column="5" border>
                <el-descriptions-item :label="$t('transaction.float')">{{
                        billing.base_amount
                    }}
                </el-descriptions-item>
                <el-descriptions-item :label="$t('transaction.shipping_total')">{{
                        billing.shipping_total
                    }}
                </el-descriptions-item>
                <el-descriptions-item :label="$t('transaction.online_total')">{{
                        billing.online_total
                    }}
                </el-descriptions-item>
                <el-descriptions-item :label="$t('transaction.card_total')">{{
                        billing.card_total
                    }}
                </el-descriptions-item>
                <el-descriptions-item :label="$t('transaction.cash_total')">{{
                        billing.cash_total
                    }}
                </el-descriptions-item>
                <el-descriptions-item :label="$t('transaction.cost_total')">{{
                        billing.cost_total
                    }}
                </el-descriptions-item>
                <el-descriptions-item :label="$t('transaction.refund_total')">{{
                        billing.refund_total
                    }}
                </el-descriptions-item>
                <el-descriptions-item :label="$t('transaction.actual_total')">{{
                        billing.actual_total
                    }}
                </el-descriptions-item>
                <el-descriptions-item :label="$t('transaction.total')">{{
                        billing.total
                    }}
                </el-descriptions-item>
                <el-descriptions-item :label="$t('transaction.net_total')">{{
                        billing.net_total
                    }}
                </el-descriptions-item>
            </el-descriptions>
            <el-form size="medium" :inline="true" style="margin-top:20px;">
                <el-form-item label="Status">
                    <el-select v-model="billing.status">
                        <el-option :label="$t('transaction.status_options.settled')" value="settled"/>
                        <el-option :label="$t('transaction.status_options.pending')" value="pending"/>
                    </el-select>
                </el-form-item>
                <el-form-item :label="$t('transaction.pos_balance')">
                    <el-input v-model="billing.pos_balance" type="number" class="w200" clearable/>
                </el-form-item>
                <el-form-item label="Notes">
                    <el-input v-model="billing.notes" class="w300" clearable/>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="handleSubmit">Submit</el-button>
                </el-form-item>
            </el-form>
        </section>
    </main-layout>
</template>

<style scoped>

</style>