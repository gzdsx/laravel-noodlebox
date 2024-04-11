<template>
    <div class="content-block">
        <div class="console-title">
            <div class="float-right">
                <el-button type="primary" size="small" @click="handleShowAdd">添加收货地址</el-button>
            </div>
            <h2>收货地址管理</h2>
        </div>
        <section class="section">
            <el-table :data="items" stripe>
                <el-table-column prop="name" label="联系人"/>
                <el-table-column prop="phone" label="电话"/>
                <el-table-column prop="formatted_address" label="地址"/>
                <el-table-column prop="postalcode" label="邮编" width="100"/>
                <el-table-column prop="isdefault" label="默认地址" width="100">
                    <template slot-scope="scope">
                        <div v-if="scope.row.isdefault" style="color: #f00;">默认地址</div>
                    </template>
                </el-table-column>
                <el-table-column label="操作" width="100" align="right">
                    <template slot-scope="scope">
                        <a @click="handleShowEdit(scope.row)">修改</a>
                        <a @click="handleDelete(scope.row.id)">删除</a>
                    </template>
                </el-table-column>
            </el-table>
        </section>

        <el-dialog title="编辑地址" :visible.sync="showDialog" :close-on-click-modal="false"
                   :close-on-press-escape="false">
            <el-form label-width="100px" size="medium">
                <el-form-item label="收货人">
                    <el-input size="medium" class="w300" v-model="address.name"/>
                </el-form-item>
                <el-form-item label="联系电话">
                    <el-input size="medium" class="w300" v-model="address.phone"/>
                </el-form-item>
                <el-form-item label="所在地">
                    <el-cascader class="w300" :props.sync="props" v-model="cascaderValue" ref="cascader"/>
                </el-form-item>
                <el-form-item label="详细地址">
                    <el-input size="medium" v-model="address.address"/>
                </el-form-item>
                <el-form-item label="邮政编码">
                    <el-input size="medium" class="w200" v-model="address.postalcode"/>
                </el-form-item>
                <el-form-item label="">
                    <el-checkbox :true-label="1" :false-label="0" v-model="address.isdefault">设为默认地址</el-checkbox>
                </el-form-item>
                <el-form-item>
                    <el-button size="medium" type="primary" class="w200" @click="handleSave">保存</el-button>
                </el-form-item>
            </el-form>
        </el-dialog>
    </div>
</template>

<script>
import ApiService from "../utils/ApiService";

export default {
    name: "Address",
    data() {
        var self = this;
        return {
            items: [],
            address: {},
            showDialog: false,
            props: {
                lazy: true,
                value: 'name',
                label: 'name',
                lazyLoad(node, resolve) {
                    const {level} = node;
                    const fid = node.data ? node.data.id : 0;
                    self.$get('/district/batchget', {fid}).then(response => {
                        const items = response.data.items.map((o) => ({
                            ...o,
                            leaf: level >= 2
                        }));
                        resolve(items);
                    });
                }
            },
            cascaderValue: [],
        }
    },
    mounted() {
        this.fetchList();
    },
    methods: {
        fetchList() {
            ApiService.get('/users/addresses').then(response => {
                this.items = response.data.items;
            });
        },
        handleShowAdd() {
            this.resetData();
            this.showDialog = true;
        },
        handleShowEdit(d) {
            this.address = d;
            this.cascaderValue = [
                d.province,
                d.city,
                d.district
            ];
            this.showDialog = true;
        },
        handleSave() {
            this.saveData();
        },
        handleSetDefault(id) {
            ApiService.post(`/addresses/${id}`, {isdefault: 1}).then(() => {
                this.fetchList();
            });
        },
        handleDelete(id) {
            this.$confirm('此操作将永久删除所选信息, 是否继续?', '提示', {
                type: 'warning'
            }).then(() => {
                ApiService.delete(`/addresses/${id}`).then(() => {
                    this.fetchList();
                });
            });
        },
        resetData() {
            this.address = {};
        },
        saveData() {
            const {address} = this;
            if (!address.name) {
                this.$message.error('请填写姓名');
                return false;
            }

            if (!address.phone) {
                this.$message.error('请填写联系电话');
                return false;
            }

            if (!this.address.address) {
                this.$message.error('请填写详细地址');
                return false;
            }

            this.showDialog = false;
            const {id} = this.address;
            if (id) {
                ApiService.put(`/users/addresses/${id}`, {address}).then(() => {
                    this.resetData();
                    this.fetchList();
                    this.$message.success('地址保存成功');
                })
            } else {
                ApiService.post('/users/addresses', {address}).then(() => {
                    this.resetData();
                    this.fetchList();
                    this.$message.success('地址保存成功');
                });
            }
        }
    }
}
</script>

<style scoped>

</style>
