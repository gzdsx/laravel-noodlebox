<template>
    <main-layout>
        <div class="d-flex" slot="header">
            <h2>门店管理</h2>
        </div>

        <div class="page-section">
            <div class="table-edit-header">
                <el-tabs @tab-click="onClickTab" value="all">
                    <el-tab-pane label="全部" name="all"></el-tab-pane>
                    <el-tab-pane label="营业中" name="opening"></el-tab-pane>
                    <el-tab-pane label="已关闭" name="closed"></el-tab-pane>
                </el-tabs>
                <div class="buttons-wrapper">
                    <router-link to="/shop/new">
                        <el-button type="primary" size="small">添加门店</el-button>
                    </router-link>
                </div>
            </div>
            <el-table :data="dataList" v-loading="loading" @selection-change="onSelectionChange">
                <el-table-column width="45" type="selection"/>
                <el-table-column label="Logo" width="70">
                    <template slot-scope="scope">
                        <a :href="scope.row.url" target="_blank">
                            <img :src="scope.row.logo" class="img-50 img-round">
                        </a>
                    </template>
                </el-table-column>
                <el-table-column prop="name" label="店铺名称"/>
                <el-table-column prop="user.nickname" width="120px" label="店主"/>
                <el-table-column prop="status_des" width="120px" label="店铺状态"/>
                <el-table-column prop="created_at" width="170" label="创建时间"/>
                <el-table-column width="50" label="操作" align="right">
                    <template slot-scope="scope">
                        <router-link :to="'/shop/edit/'+scope.row.id">编辑</router-link>
                    </template>
                </el-table-column>
            </el-table>
            <div class="tablenav tablenav-bottom">
                <div class="table-actions">
                    <el-button size="small" type="primary" :disabled="selectionIds.length === 0" @click="onBatchDelete">
                        批量删除
                    </el-button>
                    <el-button size="small" :disabled="selectionIds.length === 0"
                               @click="onBatchUpdate({status:'closed'})">批量关闭
                    </el-button>
                    <el-button size="small" :disabled="selectionIds.length === 0"
                               @click="onBatchUpdate({status:'opening'})">批量开启
                    </el-button>
                </div>
                <el-pagination
                        background
                        layout="prev, pager, next,total"
                        :total="total"
                        :page-size="pageSize"
                        :current-page="page"
                        @current-change="onPageChange"
                />
            </div>
        </div>

        <el-dialog title="店铺详情" closeable :visible.sync="showDialog" :close-on-click-modal="false"
                   :close-on-press-escape="false">
            <el-form class="description-form" label-width="90px">
                <h3>基本信息</h3>
                <el-form-item label="店铺Logo:">
                    <el-image :src="shop.logo" class="img-60"/>
                </el-form-item>
                <el-form-item label="店铺名称:">{{ shop.name }}</el-form-item>
                <el-form-item label="客服电话:">{{ shop.tel }}</el-form-item>
                <el-form-item label="店主账号:" v-if="shop.user">{{ shop.user.nickname }}</el-form-item>
                <el-form-item label="经营地址:">{{ shop.formatted_address }}</el-form-item>
                <h3>认证信息</h3>
                <template v-if="shop.certify">
                    <el-form-item label="店主姓名:">{{ shop.certify.name }}</el-form-item>
                    <el-form-item label="证件号码:">{{ shop.certify.id_card_no }}</el-form-item>
                    <el-form-item label="认证照片:">
                        <a :href="shop.certify.license_pic" target="_blank">
                            <el-image :src="shop.certify.license_pic" class="img-80"/>
                        </a>
                        <a :href="shop.certify.id_card_front" target="_blank">
                            <el-image :src="shop.certify.id_card_front" class="img-80"/>
                        </a>
                        <a :href="shop.certify.id_card_back" target="_blank">
                            <el-image :src="shop.certify.id_card_back" class="img-80"/>
                        </a>
                        <a :href="shop.certify.id_card_hand" target="_blank">
                            <el-image :src="shop.certify.id_card_hand" class="img-80"/>
                        </a>
                        <a :href="shop.certify.other_pic" target="_blank" v-if="shop.certify.other_pic">
                            <el-image :src="shop.certify.other_pic" class="img-80"/>
                        </a>
                    </el-form-item>
                </template>
                <el-form-item>
                    <el-button @click="onVerify(2)">审核不过</el-button>
                    <el-button type="primary" @click="onVerify(1)">审核通过</el-button>
                </el-form-item>
            </el-form>
        </el-dialog>
    </main-layout>
</template>

<script>
import ShopService from "../utils/ShopService";
import Pagination from "../mixins/Pagination";

export default {
    name: "ShopList",
    mixins: [Pagination],
    data() {
        return {
            shop: {},
            showDialog: false,
            params: {
                status: '',
                orderby: 'id',
                order: 'asc'
            }
        }
    },
    methods: {
        listApi() {
            return '/shops';
        },
        listParams() {
            return this.params;
        },
        onBatchDelete() {
            let ids = this.selectionIds.map((d) => d.id);
            this.$confirm('此操作将永久删除所选商品, 是否继续?', '提示', {
                type: 'warning'
            }).then(() => {
                ShopService.deleteShops(ids).then(() => {
                    this.fetchList();
                });
            });
        },
        onClickTab(tab) {
            if (tab.name === 'all') {
                this.params.status = '';
            } else {
                this.params.status = tab.name;
            }
            this.onSearch();
        },
        onBatchUpdate(data) {
            let ids = this.selectionIds.map((d) => d.id);
            ShopService.batchUpdate(ids, data).then(() => {
                this.fetchList();
            });
        },
        onShowDetail(d) {
            this.shop = d;
            this.showDialog = true;
        },
        onVerify(verify_state) {
            let {id} = this.shop;
            ShopService.verify(id, verify_state).then(() => {
                this.shop.verify_state = verify_state;
                this.showDialog = false;
                this.$showToast('请求已受理');
            });
        }
    },
    mounted() {
        this.fetchList();
    },
}
</script>

<style scoped>

</style>
