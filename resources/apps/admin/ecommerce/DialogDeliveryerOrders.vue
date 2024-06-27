<template>
    <el-dialog
            title="订单配送明细"
            width="75%"
            :visible="value"
            :close-on-click-modal="false"
            :close-on-press-escape="false"
            append-to-body
            closeable
            @close="$emit('input', false)"
    >
        <el-table
                :data="dataList"
                v-loading="loading"
                style="width: 100%">
            <el-table-column
                    prop="order_no"
                    label="订单号"
            />
            <el-table-column
                    prop="total"
                    label="订单金额"
                    width="180">
            </el-table-column>
            <el-table-column
                    prop="status"
                    label="订单状态"
                    width="180">
            </el-table-column>
            <el-table-column
                    prop="meta_data.payment_with_cash_value"
                    label="现金支付金额"
                    width="180">
            </el-table-column>
            <el-table-column prop="shipping_total" label="配送费" width="100"/>
        </el-table>
    </el-dialog>
</template>

<script>
export default {
    name: "DialogDeliveryerOrders",
    props: {
        value: {
            type: Boolean,
            default: false
        },
        deliveryer: {
            type: Object,
            default() {
                return {}
            }
        }
    },
    data() {
        return {
            dataList: [],
            loading: true
        }
    },
    watch: {
        value(val) {
            if (val) {
                this.fetchList();
            }
        }
    },
    methods: {
        fetchList() {
            let {id} = this.deliveryer;
            this.$get(`/deliveryers/${id}/orders`).then(response => {
                this.dataList = response.data.items;
            }).catch(() => {
                this.dataList = [];
            }).finally(() => {
                this.loading = false;
            });
        }
    },
    mounted() {

    }
}
</script>

<style scoped>

</style>