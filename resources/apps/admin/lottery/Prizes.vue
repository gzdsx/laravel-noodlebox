<template>
    <main-layout>
        <div class="d-flex" slot="header">
            <h2 class="flex-grow-1">奖品管理</h2>
            <div class="header-right">
                <el-button type="primary" size="small" @click="onShowAdd">添加奖品</el-button>
            </div>
        </div>

        <section class="page-section">
            <el-table :data="dataList" v-loading="loading" @selection-change="onSelectionChange">
                <el-table-column width="40" type="selection"/>
                <el-table-column label="类型" width="100">
                    <template slot-scope="scope">
                        <featured-image :src="scope.row.image" width="60px" height="60px"/>
                    </template>
                </el-table-column>
                <el-table-column label="名称">
                    <template slot-scope="scope">
                        <strong>{{ scope.row.title }}</strong>
                    </template>
                </el-table-column>
                <el-table-column label="类型" width="100">
                    <template slot-scope="scope">
                        <span v-if="scope.row.type==='product'">产品</span>
                        <span v-else>积分</span>
                    </template>
                </el-table-column>
                <el-table-column prop="percent" label="中奖概率" width="100"/>
                <el-table-column prop="sort_num" label="显示顺序" width="100"/>
                <el-table-column label="状态" width="100">
                    <template slot-scope="scope">
                        <span v-if="scope.row.status">已激活</span>
                        <span class="text-danger" v-else>未激活</span>
                    </template>
                </el-table-column>
                <el-table-column :label="$t('common.edit')" width="100" align="right">
                    <template slot-scope="scope">
                        <a @click="onShowEdit(scope.row)">{{ $t('common.edit') }}</a>
                    </template>
                </el-table-column>
            </el-table>
            <div class="tablenav tablenav-bottom">
                <div class="table-actions">
                    <el-button size="small" type="primary" :disabled="selectionIds.length === 0" @click="batchDelete">
                        {{ $t('common.batch_delete') }}
                    </el-button>
                    <el-button size="small" :disabled="selectionIds.length === 0" @click="batchUpdate('1')">
                        批量激活
                    </el-button>
                    <el-button size="small" :disabled="selectionIds.length === 0" @click="batchUpdate('0')">
                        取消激活
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
        </section>

        <el-dialog
                title="编辑奖品"
                :visible.sync="showDialog"
                :close-on-click-modal="false"
                :close-on-press-escape="false"
                closeable
        >
            <el-form size="medium" label-width="80px">
                <el-form-item label="图片">
                    <featured-image :src="prize.image" width="100px" height="100px" fit="contain" @click="onShowMedia"/>
                </el-form-item>
                <el-form-item label="名称">
                    <el-input class="w500" v-model="prize.title"/>
                </el-form-item>
                <el-form-item label="类型">
                    <el-select class="w200" v-model="prize.type">
                        <el-option label="产品" value="product"/>
                        <el-option label="积分" value="point"/>
                    </el-select>
                </el-form-item>
                <el-form-item label="积分" v-if="prize.type==='point'">
                    <el-input class="w200" v-model="prize.title"/>
                </el-form-item>
                <el-form-item label="数量">
                    <el-input class="w200" v-model="prize.stock"/>
                </el-form-item>
                <el-form-item label="中奖概率">
                    <el-input class="w200" v-model="prize.percent"/>
                </el-form-item>
                <el-form-item label="显示顺序">
                    <el-input class="w200" v-model="prize.sort_num"/>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="onSubmit">确定</el-button>
                </el-form-item>
            </el-form>
        </el-dialog>
        <media-dialog v-model="showMediaDialog" @confirm="onChooseImage"/>
    </main-layout>
</template>

<script>
import Pagination from "../mixins/Pagination";
import ApiService from "../utils/ApiService";

export default {
    name: "Prizes",
    mixins: [Pagination],
    data() {
        return {
            prize: {},
            showDialog: false,
            selectionIds: [],
            showMediaDialog: false,
        }
    },
    methods: {
        listApi() {
            return '/lottery/prizes';
        },
        onShowAdd() {
            this.resetData();
            this.showDialog = true;
        },
        onShowEdit(v) {
            this.prize = v;
            this.showDialog = true;
        },
        batchDelete() {
            let ids = this.selectionIds.map((d) => d.id);
            this.$confirm('此操作将永久删除所选信息, 是否继续?', '提示', {
                type: 'warning'
            }).then(() => {
                this.loading = true;
                ApiService.delete('/lottery/prizes/batch', {data: {ids}}).then(() => {
                    this.fetchList();
                }).finally(() => {
                    this.loading = false;
                })
            });
        },
        batchUpdate(status) {
            let ids = this.selectionIds.map((d) => d.id);
            this.loading = true;
            ApiService.put('/lottery/prizes/batch', {ids, data: {status}}).then(() => {
                this.fetchList();
                this.$message.success('奖品积更新');
            }).finally(() => {
                this.loading = false;
            });
        },
        onSubmit() {
            let {prize} = this;
            if (!prize.title) {
                this.$message.error('请填写名称');
                return false;
            }

            if (prize.id) {
                ApiService.put('/lottery/prizes/' + prize.id, {prize}).then(() => {
                    this.resetData();
                    this.fetchList();
                    this.showDialog = false;
                    this.$message.success('奖品已更新');
                }).catch(reason => {
                    this.$message.error(reason.message);
                });
            } else {
                ApiService.post('/lottery/prizes', {prize}).then(() => {
                    this.resetData();
                    this.fetchList();
                    this.showDialog = false;
                    this.$message.success('奖品已保存');
                }).catch(reason => {
                    this.$message.error(reason.message);
                });
            }
        },
        resetData() {
            this.prize = {
                id: 0,
                title: '',
                percent: '10',
                stock: 100,
                type: 'product',
                image: '',
                sort_num: 0
            }
        },
        onShowMedia() {
            this.showMediaDialog = true;
        },
        onChooseImage(d) {
            this.prize.image = d.src;
        }
    },
    mounted() {
        this.resetData();
        this.fetchList();
    },
}
</script>

<style scoped>

</style>