<template>
    <main-layout>
        <div class="d-flex" slot="header">
            <h2 class="flex-grow-1">{{ $t('ad.manage') }}</h2>
            <div>
                <el-button type="primary" size="small" @click="onShowAdd">{{ $t('ad.addnew') }}</el-button>
            </div>
        </div>

        <section class="page-section">
            <el-table header-cell-class-name="table-header-cell" :data="dataList" v-loading="loading"
                      @selection-change="onSelectionChange">
                <el-table-column width="45" type="selection"/>
                <el-table-column prop="id" width="60" label="ID"/>
                <el-table-column prop="title" :label="$t('common.name')"/>
                <el-table-column prop="type_des" width="120" :label="$t('ad.type')"/>
                <el-table-column prop="clicks" width="100" :label="$t('ad.clicks')" align="center"/>
                <el-table-column prop="state_des" width="100" :label="$t('common.status')" align="center"/>
                <el-table-column width="80" :label="$t('common.option')" align="right">
                    <template slot-scope="scope">
                        <a @click="onShowEdit(scope.row)">{{ $t('common.edit') }}</a>
                    </template>
                </el-table-column>
            </el-table>
            <div class="tablenav-bottom">
                <el-button size="small" type="primary" :disabled="selectionIds.length===0" @click="onDelete">
                    {{ $t('common.batch_delete') }}
                </el-button>
                <el-button size="small" :disabled="selectionIds.length===0"
                           @click="onBatchUpdate({available:1})">
                    {{ $t('common.activate') }}
                </el-button>
                <el-button size="small" :disabled="selectionIds.length===0"
                           @click="onBatchUpdate({available:0})">
                    {{ $t('common.deactivate') }}
                </el-button>
            </div>
        </section>

        <el-dialog :title="$t('ad.edit')" closeable :visible.sync="showDialog" :close-on-click-modal="false"
                   :close-on-press-escape="false">
            <el-form label-width="100px">
                <el-form-item :label="$t('ad.name')">
                    <el-input size="medium" class="w300" v-model="ad.title"/>
                </el-form-item>
                <el-form-item :label="$t('ad.type')">
                    <el-select size="medium" class="w300" v-model="ad.type">
                        <el-option :label="$t('ad.ad_text')" value="text"/>
                        <el-option :label="$t('ad.ad_image')" value="image"/>
                        <el-option :label="$t('ad.ad_code')" value="code"/>
                    </el-select>
                </el-form-item>
                <div v-if="ad.type==='text'">
                    <el-form-item :label="$t('ad.text')">
                        <el-input size="medium" class="w500" v-model="ad.data.text"/>
                    </el-form-item>
                    <el-form-item :label="$t('ad.link')">
                        <el-input size="medium" class="w500" v-model="ad.data.link"/>
                    </el-form-item>
                </div>
                <div v-if="ad.type==='image'">
                    <el-form-item :label="$t('ad.image')">
                        <div @click="showPicker=true">
                            <el-image :src="ad.data.image" fit="cover" class="w80 h80"/>
                        </div>
                        <div class="el-form-tips">{{ $t('ad.image_tips') }}</div>
                    </el-form-item>
                    <el-form-item :label="$t('ad.image_width')">
                        <el-input size="medium" class="w100" v-model="ad.data.width"/>
                        <div class="el-form-tips">{{ $t('ad.image_width_tips') }}</div>
                    </el-form-item>
                    <el-form-item :label="$t('ad.image_height')">
                        <el-input size="medium" class="w100" v-model="ad.data.height"/>
                        <div class="el-form-tips">{{ $t('ad.image_height_tips') }}</div>
                    </el-form-item>
                    <el-form-item :label="$t('ad.link')">
                        <el-input size="medium" v-model="ad.data.link"/>
                    </el-form-item>
                </div>

                <div v-if="ad.type==='code'">
                    <el-form-item :label="$t('ad.code')">
                        <el-input type="textarea" rows="5" v-model="ad.data.code"/>
                        <div class="el-form-tips">{{ $t('ad.code_tips') }}</div>
                    </el-form-item>
                </div>
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
import Pagination from "../mixins/Pagination";

export default {
    name: "AdList",
    mixins: [Pagination],
    data() {
        return {
            ad: {},
            showDialog: false,
            showPicker: false
        }
    },
    methods: {
        listApi() {
            return '/ads';
        },
        resetData() {
            this.ad = {
                id: 0,
                type: 'text',
                data: {}
            };
        },
        onDelete() {
            let ids = this.selectionIds.map((d) => d.id);
            this.$confirm(this.$t('common.delete_tips'), this.$t('common.delete_confirm'), {
                type: 'warning'
            }).then(() => {
                ApiService.delete('/ads/batch', {data: {ids}}).then(() => {
                    this.fetchList();
                });
            });
        },
        onSubmit() {
            let {ad} = this;
            if (!ad.title) {
                this.$message.error(this.$t('ad.name_required'));
                return false;
            }

            if (ad.id) {
                ApiService.put('/ads/' + ad.id, {ad}).then(() => {
                    this.resetData();
                    this.fetchList();
                    this.showDialog = false;
                    this.$message.success(this.$t('ad.updated'));
                });
            } else {
                ApiService.post('/ads', {ad}).then(() => {
                    this.resetData();
                    this.fetchList();
                    this.showDialog = false;
                    this.$message.success(this.$t('ad.saved'));
                });
            }
        },
        onShowAdd() {
            this.resetData();
            this.showDialog = true;
        },
        onShowEdit(d) {
            this.ad = d;
            if (this.ad.data === null) {
                this.ad.data = {};
            }
            this.showDialog = true;
        },
        onChooseImage(m) {
            this.ad.data.image = m.url;
        },
        onBatchUpdate(data) {
            let ids = this.selectionIds.map((d) => d.id);
            ApiService.put('/ads/batch', {ids, data}).then(() => {
                this.fetchList();
            });
        },
    },
    mounted() {
        this.resetData();
        this.fetchList();
    },
}
</script>

<style scoped>

</style>
