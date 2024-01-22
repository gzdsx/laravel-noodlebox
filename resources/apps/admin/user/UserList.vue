<template>
    <main-layout>
        <h2 slot="header">{{ $t('user.manage') }}</h2>
        <section class="page-section">
            <div class="form-inline">
                <div class="form-item">
                    <div class="form-item-label">UID</div>
                    <div class="form-item-input">
                        <el-input size="medium" class="w200" clearable v-model="params.uid"/>
                    </div>
                </div>
                <div class="form-item">
                    <div class="form-item-label">{{ $t('user.nickname') }}</div>
                    <div class="form-item-input">
                        <el-input size="medium" class="w200" clearable v-model="params.nickname"/>
                    </div>
                </div>
                <div class="form-item">
                    <div class="form-item-label">{{ $t('user.phone') }}</div>
                    <div class="form-item-input">
                        <el-input size="medium" class="w200" clearable v-model="params.phone"/>
                    </div>
                </div>
                <div class="form-item">
                    <div class="form-item-label">{{ $t('user.email') }}</div>
                    <div class="form-item-input">
                        <el-input size="medium" class="w200" clearable v-model="params.email"/>
                    </div>
                </div>
                <div class="form-item">
                    <el-button size="medium" type="primary" @click="onSearch">{{ $t('common.search') }}</el-button>
                </div>
            </div>
        </section>

        <div class="page-section">
            <div class="tablenav tablenav-top">
                <el-tabs @tab-click="onClickTab" value="all">
                    <el-tab-pane :label="$t('common.all')" name="all"/>
                    <el-tab-pane :label="$t('user.pending')" name="pending"/>
                    <el-tab-pane :label="$t('user.forbidden')" name="forbidden"/>
                </el-tabs>
            </div>
            <el-table :data="dataList" v-loading="loading" @selection-change="onSelectionChange">
                <el-table-column width="40" type="selection"/>
                <el-table-column prop="uid" width="80" label="UID"/>
                <el-table-column :label="$t('user.avatar')" width="70">
                    <template slot-scope="scope">
                        <el-image :src="scope.row.avatar" class="img-40" fit="cover"></el-image>
                    </template>
                </el-table-column>
                <el-table-column prop="nickname" :label="$t('user.nickname')"/>
                <el-table-column prop="phone" :label="$t('user.phone')"/>
                <el-table-column prop="group.name" width="120" :label="$t('user.group')"/>
                <el-table-column prop="created_at" width="170" :label="$t('user.regtime')"/>
                <el-table-column width="100px" :label="$t('common.option')" align="right">
                    <template slot-scope="scope">
                        <router-link :to="'/user/edit/'+scope.row.uid">{{ $t('common.edit') }}</router-link>
                    </template>
                </el-table-column>
            </el-table>
            <div class="tablenav tablenav-bottom">
                <div class="table-actions">
                    <el-button size="small" type="primary" :disabled="selectionIds.length===0" @click="onDelete">
                        {{ $t('common.batch_delete') }}
                    </el-button>
                    <el-button size="small" :disabled="selectionIds.length===0" @click="onBatchUpdate({state:1})">
                        {{ $t('user.approved') }}
                    </el-button>
                    <el-button size="small" :disabled="selectionIds.length===0" @click="onBatchUpdate({freeze:1})">
                        {{ $t('user.forbidden') }}
                    </el-button>
                    <el-button size="small" :disabled="selectionIds.length===0" @click="onBatchUpdate({freeze:0})">
                        {{ $t('user.allow_login') }}
                    </el-button>
                </div>
                <el-pagination
                        background
                        layout="prev, pager, next, total"
                        :total="total"
                        :page-size="pageSize"
                        :current-page="page"
                        @current-change="onPageChange"
                />
            </div>
        </div>
    </main-layout>
</template>

<script>
import UserService from "../utils/UserService";
import Pagination from "../mixins/Pagination";

export default {
    name: "UserList",
    mixins: [Pagination],
    data() {
        return {
            params: {
                uid: '',
                nickname: '',
                status: '',
                email: '',
                phone: ''
            },
            amount: 10000,
            showDialog: false,
            user: {},
        }
    },
    methods: {
        listApi() {
            return '/users';
        },
        listParams() {
            return this.params;
        },
        onDelete() {
            let ids = this.selectionIds.map((d) => d.uid);
            this.$confirm(this.$t('user.delete_tips'), this.$t('common.delete_confirm'), {
                type: 'warning'
            }).then(() => {
                console.log(ids);
                UserService.deleteUser(ids).then(() => {
                    this.fetchList();
                });
            });
        },
        onClickTab(tab) {
            this.params.status = tab.name;
            this.onSearch();
        },
        onBatchUpdate(data) {
            let ids = this.selectionIds.map((d) => d.uid);
            UserService.batchUpdate(ids, data).then(() => {
                this.fetchList();
            });
        },
    },
    mounted() {
        this.fetchList();
    },
}
</script>

<style scoped>

</style>
