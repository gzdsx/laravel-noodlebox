<script>
import ApiService from "../utils/ApiService";
import DialogDeliveryerBill from "./DialogDeliveryerBill";

export default {
    name: "DeliveryerBilling",
    components: {DialogDeliveryerBill},
    data() {
        return {
            loading: true,
            deliveryers: [],
            showBill: false,
            currentDriver: {
                billing:{}
            }
        }
    },
    methods: {
        fetchList() {
            ApiService.get('/deliveryers/transactions/billing').then(response => {
                this.deliveryers = response.data;
            }).catch(reason => {
                this.$message.error(reason.message);
            }).finally(() => {
                this.loading = false;
            });
        },
        handleShowBill(d) {
            this.currentDriver = d;
            this.showBill = true;
        }
    },
    mounted() {
        this.fetchList();
    }
}
</script>

<template>
    <main-layout>
        <div class="d-flex justify-content-between" slot="header">
            <h2>Driver Reports</h2>
            <router-link to="/deliveryer/transactions">
                <el-button size="small" type="primary">Histories</el-button>
            </router-link>
        </div>
        <section class="page-section" v-loading="loading">
            <el-table :data="deliveryers">
                <el-table-column prop="name" label="Driver">
                    <template slot-scope="scope">
                        <a class="el-link el-link--primary" @click="handleShowBill(scope.row)">{{ scope.row.name }}</a>
                    </template>
                </el-table-column>
                <el-table-column prop="billing.shipping_total" label="ShippingTotal"/>
                <el-table-column prop="billing.online_total" label="Online Total"/>
                <el-table-column prop="billing.card_total" label="Card Total"/>
                <el-table-column prop="billing.cash_total" label="Cash Total"/>
                <el-table-column prop="billing.cost_total" label="Cost Total"/>
                <el-table-column prop="billing.actual_total" label="Actual Total"/>
                <el-table-column label="Options" width="80" align="right">
                    <template slot-scope="scope">
                        <a class="el-link el-link--primary" :href="scope.row.links.report.href"
                           target="_blank">{{ $t('common.print') }}</a>
                    </template>
                </el-table-column>
            </el-table>
        </section>
        <dialog-deliveryer-bill
            v-model="showBill"
            :driver-name="currentDriver.name"
            :transaction="currentDriver.billing"
            @change="fetchList"/>
    </main-layout>
</template>

<style scoped>

</style>