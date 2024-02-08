<template>
    <el-dialog
            :title="$t('material.dialog_title')"
            custom-class="media-dialog"
            @close="onClose"
            :visible="value"
            :close-on-click-modal="false"
            :close-on-press-escape="false"
            append-to-body
    >
        <el-tabs v-model="tab">
            <el-tab-pane name="uploader" :label="$t('material.upload')">
                <el-upload
                        class="media-uploader"
                        drag
                        multiple
                        action="/"
                        :show-file-list="false"
                        :on-success="onUploadSuccess"
                        :on-error="onUploadError"
                        :on-change="onUploadChange"
                        :http-request="onUpload"
                >
                    <i class="el-icon-upload"></i>
                    <div class="el-upload__text">
                        <p>{{ $t('material.drag') }}</p>
                        <p>
                            <el-button type="primary" plain>{{ $t('material.choose') }}</el-button>
                        </p>
                        <p>
                            <small>{{ $t('material.limit_tips') }}</small>
                        </p>
                    </div>
                </el-upload>
            </el-tab-pane>
            <el-tab-pane name="media" :label="$t('material.library')">
                <div class="media-flexbox">
                    <div class="media-container">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <el-select size="small" v-model="params.type" @change="onChooseType">
                                    <el-option value="" :label="$t('common.all')"/>
                                    <el-option v-for="(v,k) in types" :value="k" :label="v" :key="k"/>
                                </el-select>
                            </div>
                            <div class="d-flex flex-column">
                                <div class="media-search-input">
                                    <el-input :placeholder="$t('material.search_placeholder')" size="small" clearable
                                              v-model="params.q"/>
                                    <el-button type="primary" size="small" @click="onSearch">{{ $t('common.submit') }}
                                    </el-button>
                                </div>
                            </div>
                        </div>
                        <ul class="media-list">
                            <li v-for="(media,index) in uploadFileList" :key="index">
                                <div class="thumbnail" @click="onChooseMedia(media)" v-if="media.id">
                                    <img :src="media.thumb" alt="">
                                    <div class="name" v-if="media.type!=='image'">{{ media.name }}</div>
                                    <div class="media-mask" v-if="hasMedia(media)">
                                        <i class="el-icon-success"></i>
                                    </div>
                                </div>
                                <div class="thumbnail" v-else>
                                    <el-progress
                                            color="#409EFF"
                                            define-back-color="#ccc"
                                            :stroke-width="20"
                                            :show-text="false"
                                            :percentage="media.percentage"/>
                                </div>
                            </li>
                            <li v-for="media in dataList" :key="media.id">
                                <div class="thumbnail" @click="onChooseMedia(media)">
                                    <img :src="media.thumb" alt="">
                                    <div class="name" v-if="media.type!=='image'">{{ media.name }}</div>
                                    <div class="media-mask" v-if="hasMedia(media)">
                                        <i class="el-icon-success"></i>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div class="el-loading-spinner media-loading" v-if="loading">
                            <svg viewBox="25 25 50 50" class="circular">
                                <circle cx="50" cy="50" r="20" fill="none" class="path"></circle>
                            </svg>
                        </div>
                        <div class="media-loadmore" v-if="!loading">
                            <p>{{ tips }}</p>
                            <div v-if="dataList.length<total">
                                <el-button type="primary" size="small" @click="onLoadMore">
                                    {{ $t('material.loadmore') }}
                                </el-button>
                            </div>
                        </div>
                    </div>
                    <div class="media-editing">
                        <div v-if="currentMedia.id">
                            <h2>{{ $t('material.detail') }}</h2>
                            <img :src="currentMedia.thumb" class="media-preview" alt="">
                            <p><strong>{{ currentMedia.name }}</strong></p>
                            <p>{{ currentMedia.created_at }}</p>
                            <p>{{ currentMedia.formated_size }}</p>
                            <p>{{ currentMedia.src }}</p>

                            <el-button
                                    size="small"
                                    v-clipboard:copy="currentMedia.src"
                                    v-clipboard:success="onCopy"
                            >{{ $t('common.copy_url') }}
                            </el-button>
                        </div>
                    </div>
                </div>
            </el-tab-pane>
        </el-tabs>
        <el-button
            type="primary"
            size="small"
            :disabled="selectedFiles.length===0||tab==='uploader'"
            @click="onConfirm"
            slot="footer"
            v-if="tab==='media'"
        >{{ $t('material.use_selected') }}
        </el-button>
    </el-dialog>
</template>

<script>
import MaterialService from "../utils/MaterialService";

export default {
    name: "MediaDialog",
    props: {
        value: {
            type: Boolean,
            default: false
        },
        multiple: {
            type: Boolean,
            default: false
        },
        maxCount: {
            type: Number,
            default: 15
        },
        options: {
            type: Object,
            default() {
                return {
                    type: 'image'
                }
            }
        }
    },
    data() {
        return {
            tab: 'media',
            dataList: [],
            total: 0,
            offset: 0,
            limit: 128,
            loading: true,
            uploadedCount: 0,
            selectedFiles: [],
            currentMedia: {},
            loadingService: null,
            isLoadMore: false,
            uploadFileList: [],
            params: {type: '', q: ''},
            types: []
        }
    },
    computed: {
        tips() {
            return this.$t('material.view_tips').replace(/\{total\}/g, this.total)
                .replace(/{offset}/g, this.dataList.length);
        }
    },
    watch: {
        options(val, oldVal) {
            this.params = Object.assign({}, this.params, val);
        }
    },
    methods: {
        fetchList() {
            this.loading = true;
            let {offset, limit, params} = this;
            MaterialService.list({
                ...params,
                offset,
                limit
            }).then(response => {
                const {total, items} = response.result;
                this.total = total;
                if (this.isLoadMore) {
                    this.dataList = this.dataList.concat(items);
                } else {
                    this.dataList = items;
                }
            }).catch(reason => {
                this.$message({
                    type: 'error',
                    message: reason.message
                });
            }).finally(() => {
                this.loading = false;
                this.isLoadMore = false;
            });
        },
        onClose() {
            this.$emit('input', false);
        },
        onUploadChange() {
            this.tab = "media";
        },
        onUpload(e) {
            const file = e.file;
            this.uploadFileList.unshift(file);
            const formData = new FormData();
            formData.append('file', e.file);

            Object.keys(this.options).forEach(key => {
                formData.append(key, this.options[key]);
            });

            return this.$post('/materials/upload', formData, {
                timeout: 0,
                headers: {'Content-type': 'multipart/form-data'},
                onUploadProgress: evt => {
                    file.percentage = (evt.loaded / evt.total) * 100;
                    this.uploadFileList.map((data, index) => {
                        if (data.uid === file.uid) {
                            this.uploadFileList.splice(index, 1, file);
                        }
                    });
                }
            });
        },
        onUploadSuccess(response, file, fileList) {
            //console.log('onUploadSuccess:', response);
            if (response) {
                this.uploadFileList.map((data, index) => {
                    if (data.uid === file.uid) {
                        this.uploadFileList.splice(index, 1, response.result);
                    }
                });
            }
        },
        onUploadError(err) {
            this.$message.error(err.message);
        },
        onConfirm() {
            if (this.multiple) {
                this.$emit('confirm', this.selectedFiles);
            } else {
                this.$emit('confirm', this.selectedFiles[0]);
            }

            this.selectedFiles = [];
            this.onClose();
        },
        hasMedia(file) {
            return this.selectedFiles.indexOf(file) !== -1;
        },
        onChooseMedia(file) {
            if (this.multiple) {
                let index = this.selectedFiles.indexOf(file);
                if (index === -1) {
                    if (this.selectedFiles.length < this.maxCount) {
                        this.selectedFiles.push(file);
                    }
                } else {
                    this.selectedFiles.splice(index, 1);
                }
            } else {
                this.selectedFiles = [file];
            }

            let len = this.selectedFiles.length;
            if (len > 0) {
                this.currentMedia = this.selectedFiles[len - 1];
            } else {
                this.currentMedia = {};
            }
        },
        onLoadMore() {
            if (this.dataList.length < this.total) {
                this.offset += this.limit;
                this.isLoadMore = true;
                this.fetchList();
            }
        },
        formatSize(size) {
            if (size > 1048576) {
                return (size / 1048576).toFixed(2) + 'MB';
            }
            return (size / 1024).toFixed(2) + 'KB';
        },
        onCopy() {
            this.$message.success(this.$t('common.url_copy_success'));
        },
        onChooseType(type) {
            this.params.type = type;
            this.offset = 0;
            this.dataList = [];
            this.isLoadMore = false;
            this.fetchList();
        },
        onSearch() {
            this.offset = 0;
            this.fetchList();
        },
        fetchTypes() {
            MaterialService.get('types').then(response => {
                this.types = response.result;
            });
        }
    },
    mounted() {
        this.fetchTypes();
        this.fetchList();
    },
}
</script>

<style scoped>

</style>
