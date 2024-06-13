<template>
    <main-layout>
        <h2 slot="header">{{ $t('user.manage') }}</h2>
        <section class="page-section">
            <div class="form-inline">
                <div class="form-item">
                    <div class="form-item-label">ID</div>
                    <div class="form-item-input">
                        <el-input size="medium" class="w200" clearable v-model="params.id"/>
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
                        <el-input size="medium" class="w200" clearable v-model="params.phone_number"/>
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
                <el-table-column prop="id" width="80" label="ID"/>
                <el-table-column :label="$t('user.avatar')" width="70">
                    <template slot-scope="scope">
                        <el-image :src="scope.row.avatar" class="img-40" fit="cover"></el-image>
                    </template>
                </el-table-column>
                <el-table-column prop="nickname" :label="$t('user.nickname')"/>
                <el-table-column prop="phone_number" :label="$t('user.phone')"/>
                <el-table-column prop="email" :label="$t('user.email')"/>
                <el-table-column prop="points" width="80" :label="$t('common.points')"/>
                <el-table-column prop="created_at" width="170" :label="$t('user.regtime')"/>
                <el-table-column width="100px" :label="$t('common.option')" align="right">
                    <template slot-scope="scope">
                        <el-dropdown trigger="click" @command="onCommand">
                            <div class="el-link el-link--primary el-dropdown-link">
                                <span>{{ $t('common.edit') }}</span>
                            </div>
                            <el-dropdown-menu slot="dropdown">
                                <el-dropdown-item :command="{'act':'edit-profile',user:scope.row}">修改资料
                                </el-dropdown-item>
                                <el-dropdown-item :command="{'act':'edit-points',user:scope.row}">修改积分
                                </el-dropdown-item>
                            </el-dropdown-menu>
                        </el-dropdown>
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
        <el-dialog width="500px" title="Edit Points" closeable
                   :visible.sync="showDialog"
                   :close-on-click-modal="false"
                   :close-on-press-escape="false">
            <el-form ref="form" size="medium" label-width="80px" width="400px">
                <el-form-item label="Action">
                    <el-select v-model="pointData.action" placeholder="Select action">
                        <el-option label="Add" value="add"/>
                        <el-option label="Subtract" value="subtract"/>
                    </el-select>
                </el-form-item>
                <el-form-item label="Amount">
                    <el-input v-model="pointData.amount" class="w200" type="number" min="0"/>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="onExchange">{{ $t('common.submit') }}</el-button>
                </el-form-item>
            </el-form>
        </el-dialog>
    </main-layout>
</template>

<script>
import UserService from "../utils/UserService";
import Pagination from "../mixins/Pagination";
import ApiService from "../utils/ApiService";

export default {
    name: "UserList",
    mixins: [Pagination],
    data() {
        return {
            params: {
                id: '',
                nickname: '',
                status: '',
                email: '',
                phone_number: ''
            },
            amount: 10000,
            showDialog: false,
            user: {},
            pointData: {
                action: 'add',
                amount: 0
            }
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
            let ids = this.selectionIds.map((d) => d.id);
            this.$confirm(this.$t('user.delete_tips'), this.$t('common.delete_confirm'), {
                type: 'warning'
            }).then(() => {
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
            let ids = this.selectionIds.map((d) => d.id);
            UserService.batchUpdate(ids, data).then(() => {
                this.fetchList();
            });
        },
        onCommand(cmd) {
            console.log(cmd);
            switch (cmd.act) {
                case 'edit-points':
                    this.onEditPoints(cmd.user);
                    break;
                case 'edit-profile':
                    this.$router.push({name: 'user-edit', params: {id: cmd.user.id}});
                    break;
            }
        },
        onEditPoints(u) {
            this.user = u;
            this.showDialog = true;
        },
        onExchange() {
            let {id} = this.user;
            ApiService.post('/users/' + id + '/points', this.pointData).then(() => {
                this.$message.success(this.$t('user.updated'));
                this.fetchList();
            }).catch(reason => {
                console.log(reason);
                this.$message.error(reason.message);
            }).finally(() => {
                this.showDialog = false;
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
