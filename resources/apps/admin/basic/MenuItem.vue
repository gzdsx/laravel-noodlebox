<template>
    <main-layout>
        <div class="d-flex" slot="header">
            <div class="header-left">
                <el-breadcrumb>
                    <el-breadcrumb-item to="/menu/list">{{ $t('menu.manage') }}</el-breadcrumb-item>
                    <el-breadcrumb-item>{{ menu.name }}</el-breadcrumb-item>
                </el-breadcrumb>
            </div>
            <div>
                <el-button type="primary" size="small" @click="onShowAdd(0)">{{ $t('menu.add_item') }}</el-button>
            </div>
        </div>
        <section class="page-section">
            <table class="dsxui-listtable">
                <colgroup>
                    <col width="50"></col>
                    <col width="150"></col>
                    <col></col>
                    <col width="100"></col>
                    <col width="100"></col>
                    <col width="200"></col>
                </colgroup>
                <thead>
                <tr>
                    <th>{{ $t('common.icon') }}</th>
                    <th>{{ $t('common.name') }}</th>
                    <th>{{ $t('common.link') }}</th>
                    <th>{{ $t('common.show') }}</th>
                    <th>{{ $t('common.sort') }}</th>
                    <th class="align-right">{{ $t('common.option') }}</th>
                </tr>
                </thead>
            </table>
            <template v-if="dataList.length>0">
                <div v-for="(item,idx1) in dataList" :key="idx1">
                    <table class="dsxui-listtable">
                        <colgroup>
                            <col width="50"></col>
                            <col width="150"></col>
                            <col></col>
                            <col width="100"></col>
                            <col width="100"></col>
                            <col width="200"></col>
                        </colgroup>
                        <tbody>
                        <tr>
                            <td>
                                <img :src="item.image" class="img-30" v-if="item.image"/>
                                <div class="img-30 img-placeholder" v-else></div>
                            </td>
                            <td><span class="font-bold">{{ item.title }}</span></td>
                            <td><span class="font-bold">{{ item.url }}</span></td>
                            <td>
                                <div @click="onToggle(item)">
                                    <i class="el-icon-close font-22" v-if="item.hide"></i>
                                    <i class="el-icon-check font-22" v-else></i>
                                </div>
                            </td>
                            <td>{{ item.sort_num }}</td>
                            <td class="align-right">
                                <div class="action-links">
                                    <a @click="onShowAdd(item.id)">{{ $t('menu.add_sub_item') }}</a>
                                    <span>|</span>
                                    <a @click="onShowEdit(item)">{{ $t('common.edit') }}</a>
                                    <span>|</span>
                                    <a @click="onDelete(item.id)">{{ $t('common.delete') }}</a>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                        <tbody v-if="item.children && item.children.length">
                        <tr v-for="(child,idx2) in item.children" :key="idx2">
                            <td>
                                <img :src="child.image" class="img-30" v-if="child.image"/>
                                <div class="img-placeholder img-30" v-else></div>
                            </td>
                            <td>
                                <div class="cell-flex">
                                    <span class="child-item-icon"></span>
                                    <span>{{ child.title }}</span>
                                </div>
                            </td>
                            <td>{{ child.url }}</td>
                            <td>
                                <div @click="onToggle(child)">
                                    <i class="el-icon-close font-22" v-if="child.hide"></i>
                                    <i class="el-icon-check font-22" v-else></i>
                                </div>
                            </td>
                            <td>{{ child.sort_num }}</td>
                            <td class="align-right">
                                <div class="action-links">
                                    <a @click="onShowEdit(child)">{{ $t('common.edit') }}</a>
                                    <span>|</span>
                                    <a @click="onDelete(child.id)">{{ $t('common.delete') }}</a>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </template>
            <div class="el-table__empty-block" v-else>
                <span class="el-table__empty-text">{{ $t('common.no_access') }}</span>
            </div>
        </section>
        <el-dialog :title="$t('menu.edit_item')" closeable
                   :visible.sync="showDialog"
                   :close-on-click-modal="false"
                   :close-on-press-escape="false">
            <el-form label-width="80px">
                <el-form-item :label="$t('common.image')">
                    <div @click="showPicker=true">
                        <el-image :src="item.image" fit="cover" class="img-60" v-if="item.image"/>
                        <div class="img-60 img-placeholder" v-else></div>
                    </div>
                </el-form-item>
                <el-form-item :label="$t('common.name')">
                    <el-input size="medium" class="w200" v-model="item.title"/>
                </el-form-item>
                <el-form-item :label="$t('common.link')">
                    <el-input size="medium" class="w500" v-model="item.url"/>
                </el-form-item>
                <el-form-item :label="$t('common.sort')">
                    <el-input size="medium" class="w200" v-model="item.sort_num"/>
                </el-form-item>
                <el-form-item :label="$t('menu.item_parent')">
                    <el-select class="w200" v-model="item.parent_id" @change="onFidChange">
                        <el-option :label="$t('menu.item_to_top')" :value="0"/>
                        <el-option
                                v-for="(it,idx) in dataList"
                                :key="idx"
                                :label="it.title"
                                :value="it.id"
                                v-if="item.id !== it.id"
                        />
                    </el-select>
                </el-form-item>
                <el-form-item :label="$t('menu.target')">
                    <el-select class="w200" v-model="item.target">
                        <el-option :label="$t('menu.target_self')" value="_self"/>
                        <el-option :label="$t('menu.target_blank')" value="_blank"/>
                        <el-option :label="$t('menu.target_top')" value="_top"/>
                    </el-select>
                </el-form-item>
                <el-form-item :label="$t('menu.hide')">
                    <el-switch :active-value="1" :inactive-value="0" v-model="menu.hide"/>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" size="medium" class="w100" @click="onSubmit">{{ $t('common.submit') }}
                    </el-button>
                </el-form-item>
            </el-form>
        </el-dialog>
        <media-dialog v-model="showPicker" @confirm="onChooseImage"/>
    </main-layout>
</template>

<script>
import ApiService from "../utils/ApiService";

export default {
    name: "MenuItem",
    data() {
        return {
            menu: {},
            item: {},
            dataList: [],
            showDialog: false,
            showPicker: false,
            selectionIds: [],
            props: {
                label: 'title'
            }
        }
    },
    methods: {
        fetchList() {
            let {menu_id} = this.$route.params;
            ApiService.get('/menus/' + menu_id).then(response => {
                let {menu, items} = response.result;
                this.menu = menu;
                this.dataList = items;
            });
        },
        resetData() {
            let {menu_id} = this.$route.params;
            this.item = {id: 0, parent_id: 0, hide: 0, menu_id};
        },
        onSubmit() {
            let {item} = this;
            if (!item.title) {
                this.$message.error(this.$t('menu.name_required'));
                return false;
            }

            ApiService.post('/menu-items', {item}).then(() => {
                this.resetData();
                this.fetchList();
                this.showDialog = false;
                this.$message.success(this.$t('menu.saved'));
            });
        },
        onShowAdd(id) {
            this.resetData();
            this.item.parent_id = id;
            this.showDialog = true;
        },
        onShowEdit(d) {
            this.item = d;
            this.showDialog = true;
        },
        onDelete(id) {
            this.$confirm(this.$t('common.delete_tips'), this.$t('delete_confirm'), {
                type: 'warning'
            }).then(() => {
                ApiService.delete('/menu-items/batch', {data: {ids: [id]}}).then(() => {
                    this.fetchList();
                });
            });
        },
        onFidChange(val) {
            this.$forceUpdate();
        },
        onChooseImage(m) {
            this.item.image = m.url;
        },
        onToggle(item) {
            let {id} = item;
            ApiService.post('/menu-items/toggle', {id}).then(() => {
                item.hide = item.hide === 0 ? 1 : 0;
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
