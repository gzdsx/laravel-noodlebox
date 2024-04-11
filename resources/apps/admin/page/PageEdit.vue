<template>
    <main-layout>
        <div class="d-flex" slot="header">
            <div class="header-left">
                <h2>{{ page.id ? $t('page.edit') : $t('page.addnew') }}</h2>
            </div>
            <div class="d-flex column-gap-10">
                <a :href="page.url" target="_blank" v-if="page.id">
                    <el-button size="small">{{ $t('common.preview') }}</el-button>
                </a>
                <router-link to="/page/new">
                    <el-button type="primary" size="small">{{ $t('page.addnew') }}</el-button>
                </router-link>
            </div>
        </div>

        <div class="post-body">
            <div class="post-body-main">
                <div class="page-section">
                    <el-form label-width="100px">
                        <el-form-item :label="$t('common.title')">
                            <el-input size="medium" class="w-100" v-model="page.title"/>
                        </el-form-item>
                        <el-form-item :label="$t('common.url')">
                            <el-input size="medium" class="w-100" v-model="page.slug">
                                <span slot="prepend">{{siteUrl}}/</span>
                            </el-input>
                        </el-form-item>
                        <el-form-item :label="$t('common.keywords')">
                            <el-input size="medium" class="w-100" v-model="page.keywords"/>
                        </el-form-item>
                        <el-form-item :label="$t('common.description')">
                            <el-input type="textarea" rows="5" class="w-100" v-model="page.description"/>
                        </el-form-item>
                        <el-form-item :label="$t('common.content')">
                            <wang-editor v-model="page.content"/>
                        </el-form-item>
                    </el-form>
                </div>
            </div>
            <div class="post-body-box">
                <div class="post-card">
                    <div class="post-card-header">
                        <h2>{{ $t('common.featured_image') }}</h2>
                    </div>
                    <div class="post-card-body">
                        <div class="feature-image-box" @click="showMediaDialog=true">
                            <img :src="page.image" v-if="page.image" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <fixed-bottom>
            <el-button class="w100" :disabled="disabled" @click="$router.go(-1)">{{ $t('common.cancel') }}</el-button>
            <el-button class="w100" :disabled="disabled" type="primary" @click="onSubmit">{{
                $t('common.save')
                }}
            </el-button>
        </fixed-bottom>
        <media-dialog v-model="showMediaDialog" @confirm="onChooseImage"/>
    </main-layout>
</template>

<script>
import ApiService from "../utils/ApiService";

export default {
    name: "PageEdit",
    data() {
        return {
            page: {},
            disabled: false,
            showMediaDialog: false,
            siteUrl: window.siteUrl || window.location.origin,
        }
    },
    methods: {
        fetchData() {
            let {id} = this.$route.params;
            if (!id) return;
            ApiService.get('/pages/' + id).then(response => {
                this.page = response.data;
            }).catch(reason => {
                this.$message.error(reason.message);
            });
        },
        onSubmit() {
            let {page} = this;
            if (!page.title) {
                this.$message.error(this.$t('page.title_required'));
                return false;
            }

            this.disabled = true;

            if (page.id) {
                ApiService.put('/pages/' + page.id, {page}).then(() => {
                    this.$message.success(this.$t('page.updated'));
                    this.fetchData();
                }).finally(() => {
                    this.disabled = false;
                });
            } else {
                ApiService.post('/pages', {page}).then(res => {
                    this.$message.success(this.$t('page.saved'));
                    this.$router.replace('/page/edit/' + res.data.id);
                }).finally(() => {
                    this.disabled = false;
                });
            }
        },
        resetData() {
            this.page = {
                title: '',
                name: '',
                image: '',
                content: ''
            };
        },
        onChooseImage(m) {
            this.page.image = m.src;
        },
    },
    mounted() {
        this.resetData();
        this.fetchData();
    },
}
</script>

<style scoped>

</style>
