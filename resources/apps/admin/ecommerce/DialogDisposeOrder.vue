<template>
    <el-dialog
            title="订单处理"
            width="50%"
            :visible="value"
            :close-on-click-modal="false"
            :close-on-press-escape="false"
            append-to-body
            closeable
            @close="close"
    >
        <el-form label-width="100px" size="medium" v-loading="loading">
            <el-form-item label="订单号">
                {{ order.order_no }}
            </el-form-item>
            <el-form-item label="配送地址" v-if="order.shipping">
                <div style="line-height: 1.4;">
                    <div>{{ order.shipping.name }}</div>
                    <div>{{ order.shipping.address }}</div>
                    <div v-if="order.shipping.county">{{ order.shipping.county }}</div>
                    <div v-if="order.shipping.city">{{ order.shipping.city }}</div>
                    <div v-if="order.shipping.state">{{ order.shipping.state }}</div>
                    <div v-if="order.shipping.phone">{{ order.shipping.phone }}</div>
                </div>
            </el-form-item>
            <el-form-item label="订单状态">
                <el-select size="medium" class="w300" v-model="order.status">
                    <el-option
                            v-for="(v,k) in statusList"
                            :label="v"
                            :value="k"
                            :key="k"
                    />
                </el-select>
            </el-form-item>
            <el-form-item label="配送员">
                <el-select size="medium" class="w300" v-model="order.deliveryer_id">
                    <el-option
                            v-for="(v,k) in deliveryerList"
                            :label="v.name"
                            :value="v.id"
                            :key="k"
                    />
                </el-select>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="onSubmit">提交</el-button>
            </el-form-item>
        </el-form>
    </el-dialog>
</template>

<script>
import ApiService from "../utils/ApiService";

export default {
    name: "DialogDisposeOrder",
    props: {
        value: {
            type: Boolean,
            default: false
        },
        order: {
            type: Object,
            default() {
                return {
                    status: 'pending',
                    deliveryer_id: ''
                }
            }
        }
    },
    data() {
        return {
            statusList: [],
            deliveryerList: [],
            disposeData: {
                status: 'pending',
                deliveryer_id: ''
            },
            loading: false
        }
    },
    methods: {
        close() {
            this.$emit('input', false);
        },
        fetchStatusList() {
            this.$get('/orders/statuses').then(response => {
                this.statusList = response.data;
            });
        },
        fetchDeliveryerList() {
            this.$get('/deliveryers?limit=100').then(response => {
                this.deliveryerList = response.data.items;
            });
        },
        onSubmit() {
            let {id, status, deliveryer_id} = this.order;
            this.loading = true;
            ApiService.put(`/orders/${id}`, {
                order: {
                    status,
                    deliveryer_id
                }
            }).then(() => {
                this.$message.success('订单已更新');
            }).finally(() => {
                this.loading = false;
            });
        }
    },
    mounted() {
        this.fetchStatusList();
        this.fetchDeliveryerList();
    },
}
</script>

<style scoped>

</style>