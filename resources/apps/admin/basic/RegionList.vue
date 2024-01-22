<template>
    <main-layout>
        <div class="d-flex" slot="header">
            <div class="header-left">
                <el-breadcrumb separator-class="el-icon-arrow-right">
                    <el-breadcrumb-item :to="{ path: '/regions' }">Regions</el-breadcrumb-item>
                    <el-breadcrumb-item v-for="ancestor in ancestors" :key="ancestor.id"
                                        :to="'/regions?parent_id='+ancestor.id">{{ ancestor.name }}
                    </el-breadcrumb-item>
                </el-breadcrumb>
            </div>
            <div>
                <el-button type="primary" size="small" @click="onLoadParents" v-if="parent_id>0">Go Back
                </el-button>
                <el-button type="primary" size="small" @click="onShowAdd">New Region</el-button>
            </div>
        </div>

        <div class="page-section">
            <el-checkbox-group v-model="selectionIds">
                <table class="dsxui-listtable">
                    <colgroup>
                        <col style="width: 50px;">
                        <col>
                        <col>
                        <col style="width: 100px;">
                    </colgroup>
                    <thead>
                    <tr>
                        <th>
                            <el-checkbox @change="onCheckAll"/>
                        </th>
                        <th>Name</th>
                        <th>Short Name</th>
                        <th class="text-right">Option</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(item,index) in dataList" :key="index">
                        <td>
                            <el-checkbox :label="item.id">{{ '' }}</el-checkbox>
                        </td>
                        <td><a @click="showRegion(item)">{{ item.name }}</a></td>
                        <td><a @click="showRegion(item)">{{ item.short_name }}</a></td>
                        <td class="text-right"><a class="text-primary" @click="onShowEdit(item)">Edit</a></td>
                    </tr>
                    </tbody>
                </table>
            </el-checkbox-group>
            <div class="table-edit-footer">
                <el-button size="small" type="primary" :disabled="selectionIds.length===0" @click="onDelete">
                    Batch Delete
                </el-button>
            </div>
        </div>
        <el-dialog title="New Region" closeable :visible.sync="showDialog" :close-on-click-modal="false"
                   :close-on-press-escape="false">
            <table class="dsxui-formtable">
                <colgroup>
                    <col style="width: 120px;">
                    <col style="width: 300px;">
                    <col>
                </colgroup>
                <tbody>
                <tr v-if="parent_id">
                    <td class="cell-label">Parent</td>
                    <td class="cell-input">
                        <el-input size="medium" v-model="current.name" disabled="true"/>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td class="cell-label">Name</td>
                    <td class="cell-input">
                        <el-input size="medium" v-model="region.name"/>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td class="cell-label">Short name</td>
                    <td class="cell-input">
                        <el-input size="medium" v-model="region.short_name"/>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td class="cell-label">Sort</td>
                    <td class="cell-input">
                        <el-input size="medium" v-model="region.sort_num"></el-input>
                    </td>
                    <td class="cell-tips"></td>
                </tr>
                </tbody>
                <tfoot>
                <tr>
                    <td></td>
                    <td>
                        <el-button type="primary" size="medium" class="w100" @click="onSubmit">Submit</el-button>
                    </td>
                    <td></td>
                </tr>
                </tfoot>
            </table>
        </el-dialog>
    </main-layout>
</template>

<script>
import ApiService from "../utils/ApiService";

export default {
    name: "RegionList",
    data() {
        return {
            loading: true,
            dataList: [],
            current: {},
            region: {},
            parent_id: 0,
            showDialog: false,
            selectionIds: [],
            ancestors: []
        }
    },
    methods: {
        fetchList() {
            this.loading = true;
            const {parent_id} = this;
            ApiService.get('/regions', {params: {parent_id}}).then(response => {
                this.dataList = response.result.items;
            }).catch(reason => {
                this.$message.error(reason.message);
            }).finally(() => {
                this.loading = false;
            });
        },
        fetchData() {
            const {parent_id} = this;
            if (parent_id) {
                ApiService.get('/regions/' + parent_id).then(response => {
                    this.current = response.result;
                    this.ancestors = this.getAncestors(response.result).reverse();
                });
            }
        },
        resetData() {
            this.region = {sort_num: 0}
        },
        showRegion(r) {
            this.$router.push('/regions?parent_id=' + r.id);
        },
        onLoadParents() {
            this.parent_id = this.current.parent_id;
            this.fetchData();
            this.fetchList();
        },
        onShowEdit(d) {
            this.region = d;
            this.showDialog = true;
        },
        onShowAdd() {
            const {parent_id} = this;
            this.region = {parent_id, sort_num: 0};
            this.showDialog = true;
        },
        onSubmit() {
            let {region} = this;
            if (!region.name) {
                this.$message.error('请填写区位名称');
                return false;
            }

            if (region.id) {
                ApiService.put('/regions/' + region.id, {region}).then(() => {
                    this.resetData();
                    this.fetchList();
                    this.showDialog = false;
                });
            } else {
                ApiService.post('/regions', {region}).then(() => {
                    this.resetData();
                    this.fetchList();
                    this.showDialog = false;
                });
            }
        },
        onDelete() {
            let ids = this.selectionIds;
            this.$confirm('此操作将永久删除所选信息, 是否继续?', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning'
            }).then(() => {
                ApiService.post('/districts/batch-delete', {ids}).then(() => {
                    this.fetchList();
                });
            });
        },
        onCheckAll(v) {
            if (v) {
                this.selectionIds = this.items.map((g) => g.id);
            } else {
                this.selectionIds = [];
            }
        },
        getAncestors(region) {
            const parents = [region];

            function traverse(parent) {
                if (parent && parent.ancestor) {
                    parents.push(parent.ancestor);
                    traverse(parent.ancestor);
                }
            }

            traverse(region);
            return parents;
        }
    },
    mounted() {
        this.parent_id = this.$route.query.parent_id || 0;
        this.fetchData();
        this.fetchList();
    },
}
</script>

<style scoped>

</style>
