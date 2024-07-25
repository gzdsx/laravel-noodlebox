<template>
    <el-dialog :title="title" closeable :visible.sync="visible" :close-on-click-modal="false"
               :close-on-press-escape="false" width="60%" @close="close">
        <el-table :data="billing.orders" border>
            <el-table-column :label="$t('order.no')" prop="short_code"/>
            <el-table-column :label="$t('order.shipping_zone')" prop="shipping_line.zone_title"/>
            <el-table-column :label="$t('order.shipping_total')" prop="shipping_total"/>
            <el-table-column :label="$t('Cost F')" prop="cost_total"/>
            <el-table-column :label="$t('order.total')" prop="total"/>
            <el-table-column :label="$t('order.payment_method')" prop="payment_method"/>
        </el-table>
        <el-descriptions title="" direction="vertical" :column="4" border>
            <el-descriptions-item :label="$t('transaction.base_amount')">
                {{ billing.base_amount }}
            </el-descriptions-item>
            <el-descriptions-item :label="$t('transaction.shipping_total')">
                {{ billing.shipping_total }}
            </el-descriptions-item>
            <el-descriptions-item :label="$t('transaction.online_total')">
                {{ billing.online_total }}
            </el-descriptions-item>
            <el-descriptions-item :label="$t('transaction.cash_total')">
                {{ billing.cash_total }}
            </el-descriptions-item>
            <el-descriptions-item :label="$t('transaction.card_total')">
                {{ billing.card_total }}
            </el-descriptions-item>
            <el-descriptions-item label="Cost Total">
                {{ billing.cost_total }}
            </el-descriptions-item>
            <el-descriptions-item :label="$t('transaction.total')">
                {{ billing.actual_total }}
            </el-descriptions-item>
            <el-descriptions-item :label="$t('transaction.actual_total')">
                {{ billing.actual_total }}
            </el-descriptions-item>
        </el-descriptions>
        <el-form size="medium" :inline="true" style="margin-top:20px;" v-if="transaction.status !== 'settled'">
            <el-form-item>
                <el-select v-model="billing.status">
                    <el-option :label="$t('transaction.status_options.settled')" value="settled"/>
                    <el-option :label="$t('transaction.status_options.pending')" value="pending"/>
                </el-select>
            </el-form-item>
            <el-form-item label="Notes">
                <el-input v-model="billing.notes" class="w300" clearable/>
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
    name: "DialogDeliveryerBill",
    props: {
        value: {
            type: Boolean,
            default: false
        },
        transaction: {
            id: 0,
            status:'pending',
            orders: [],
        },
        driverName:{
            type: String,
            default: ''
        }
    },
    data() {
        return {
            visible: false,
            billing: {
                base_amount: 0,
                shipping_total: 0,
                online_total: 0,
                cash_total: 0,
                card_total: 0,
                cost_total: 0,
                total: 0,
                actual_total: 0,
                status: 'pending',
                orders: []
            },
            title:'Diver Report'
        }
    },
    watch: {
        value(newVal, oldVal) {
            this.visible = newVal;
        },
        transaction(newVal, oldVal) {
            console.log('newValue',newVal);
            this.billing = {
                ...this.billing,
                ...newVal
            };

        },
        driverName(newVal, oldVal){
            this.title = 'Driver Report - '+newVal
        }
    },
    methods: {
        close() {
            this.$emit('input', false);
        },
        handleSubmit() {
            let {id, deliveryer_id,status} = this.billing;
            console.log(this.billing);
            if (id){
                ApiService.put(`/deliveryers/${deliveryer_id}/transactions/${id}`, {status}).then(() => {
                    this.$message.success('Updated Success');
                    this.$emit('input', false);
                    this.$emit('change');
                }).catch(reason => {

                }).finally(() => {

                });
            }else{
                ApiService.post(`/deliveryers/${deliveryer_id}/transactions`, {status}).then(() => {
                    this.$message.success('Submitted Success');
                    this.$emit('input', false);
                    this.$emit('change');
                }).catch(reason => {

                }).finally(() => {

                });
            }
        },
    }
}
</script>

<style scoped>

</style>