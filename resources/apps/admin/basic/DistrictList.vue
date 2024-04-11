<template>
    <main-layout>
        <div class="d-flex" slot="header">
            <div class="header-left">
                <el-breadcrumb separator-class="el-icon-arrow-right">
                    <el-breadcrumb-item :to="{ path: '/district/list' }">{{$t('region.manage')}}</el-breadcrumb-item>
                    <el-breadcrumb-item v-for="ancestor in ancestors" :key="ancestor.id"
                                        :to="'/district/list?parent_id='+ancestor.id">{{ ancestor.name }}
                    </el-breadcrumb-item>
                </el-breadcrumb>
            </div>
            <div>
                <el-button type="primary" size="small" @click="showDistricts(current.parent_id)" v-if="parent_id>0">
                    {{$t('region.go_back')}}
                </el-button>
                <el-button type="primary" size="small" @click="onShowAdd">{{$t('region.addnew')}}</el-button>
            </div>
        </div>

        <section class="page-section">
            <el-table :data="dataList" :lading="loading" @selection-change="onSelectionChange">
                <el-table-column width="45" type="selection"/>
                <el-table-column :label="$t('region.name')">
                    <template slot-scope="scope">
                        <a @click="showDistricts(scope.row.id)">{{ scope.row.name }}</a>
                    </template>
                </el-table-column>
                <el-table-column prop="short_name" width="200" :label="$t('region.short_name')"/>
                <el-table-column prop="pinyin" width="100" :label="$t('region.pinyin')"/>
                <el-table-column prop="letter" width="100" :label="$t('region.letter')"/>
                <el-table-column prop="zonecode" width="100" :label="$t('region.zone_code')"/>
                <el-table-column prop="lng" width="100" :label="$t('region.lng')"/>
                <el-table-column prop="lat" width="100" :label="$t('region.lat')"/>
                <el-table-column width="80" align="right" :label="$t('common.option')">
                    <template slot-scope="scope">
                        <a @click="onShowEdit(scope.row)">{{ $t('common.edit')}}</a>
                    </template>
                </el-table-column>
            </el-table>
            <div class="table-edit-footer">
                <el-button size="small" type="primary" :disabled="selectionIds.length===0" @click="onDelete">
                    {{$t('common.batch_delete')}}
                </el-button>
            </div>
        </section>
        <el-dialog :title="$t('region.edit')" closeable :visible.sync="showDialog" :close-on-click-modal="false"
                   :close-on-press-escape="false">
            <el-form label-width="120px">
                <el-form-item :label="$t('region.name')">
                    <el-input size="medium" class="w300" v-model="district.name"/>
                </el-form-item>
                <el-form-item :label="$t('region.short_name')">
                    <el-input size="medium" class="w300" v-model="district.short_name"/>
                </el-form-item>
                <el-form-item :label="$t('region.pinyin')">
                    <el-input size="medium" class="w300" v-model="district.pinyin"/>
                </el-form-item>
                <el-form-item :label="$t('region.letter')">
                    <el-input size="medium" class="w200" v-model="district.letter"/>
                </el-form-item>
                <el-form-item :label="$t('region.zone_code')">
                    <el-input size="medium" class="w200" v-model="district.zonecode"/>
                </el-form-item>
                <el-form-item :label="$t('region.lng')">
                    <el-input size="medium" class="w200" v-model="district.lng"/>
                </el-form-item>
                <el-form-item :label="$t('region.lat')">
                    <el-input size="medium" class="w200" v-model="district.lat"/>
                </el-form-item>
                <el-form-item :label="$t('region.city_code')">
                    <el-input size="medium" class="w200" v-model="district.citycode"/>
                </el-form-item>
                <el-form-item :label="$t('region.zip_code')">
                    <el-input size="medium" class="w200" v-model="district.zipcode"/>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" size="medium" class="w100" @click="onSubmit">{{ $t('common.submit')}}</el-button>
                </el-form-item>
            </el-form>
        </el-dialog>
    </main-layout>
</template>

<script>
import ApiService from "../utils/ApiService";

export default {
    name: "DistrictList",
    data() {
        return {
            loading: true,
            dataList: [],
            parent_id: 0,
            current: {},
            district: {},
            showDialog: false,
            selectionIds: [],
            ancestors: []
        }
    },
    methods: {
        fetchList() {
            let {parent_id} = this;
            this.loading = true;
            ApiService.get('/districts?parent=' + parent_id).then(response => {
                this.dataList = response.data.items;
            }).finally(() => {
                this.loading = false;
            });
        },
        fetchData() {
            let {parent_id} = this;
            if (parent_id) {
                ApiService.get('/districts/' + parent_id).then(response => {
                    this.current = response.data;
                    this.ancestors = this.getAncestors(response.data).reverse();
                });
            }
        },
        showDistricts(id) {
            this.$router.push('/district/list?parent_id=' + id);
        },
        onShowEdit(d) {
            this.district = d;
            this.showDialog = true;
        },
        onShowAdd() {
            this.district = {
                parent_id: this.parent_id,
                level: this.parent_id > 0 ? this.current.level + 1 : 1
            };
            this.showDialog = true;
        },
        onSubmit() {
            let {district} = this;
            if (!district.name) {
                this.$message.error(this.$t('name_required'));
                return false;
            }

            if (district.id) {
                ApiService.put('/districts/' + district.id, {district}).then(() => {
                    this.fetchList();
                    this.district = {};
                    this.showDialog = false;
                    this.$message.success(this.$t('region.updated'));
                });
            } else {
                district.parent_id = this.parent_id;
                ApiService.post('/districts', {district}).then(() => {
                    this.fetchList();
                    this.district = {};
                    this.showDialog = false;
                    this.$message.success(this.$t('region.saved'));
                });
            }
        },
        onDelete() {
            let ids = this.selectionIds.map(d => d.id);
            this.$confirm(this.$t('common.delete_tips'), this.$t('common.delete_confirm'), {
                type: 'warning'
            }).then(() => {
                ApiService.delete('/districts/batch', {data: {ids}}).then(() => {
                    this.fetchList();
                });
            });
        },
        onSelectionChange(val) {
            this.selectionIds = val;
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
    created() {
        const {parent_id} = this.$route.query;
        if (parent_id) {
            this.parent_id = parent_id;
            this.fetchData();
        }
    },
    mounted() {
        this.fetchList();
    },
}
</script>

<style scoped>

</style>
