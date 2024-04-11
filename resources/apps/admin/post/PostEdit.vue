<template>
    <main-layout>
        <div class="d-flex" slot="header">
            <h2 class="flex-grow-1">{{ post.id ? $t('post.edit') : $t('post.addnew') }}</h2>
            <div class="d-flex column-gap-10">
                <a :href="post.url" target="_blank" v-if="post.url">
                    <el-button size="small">{{ $t('post.preview') }}</el-button>
                </a>
                <router-link :to="'/post/new?type='+type">
                    <el-button size="small" type="primary">{{ $t('post.addnew') }}</el-button>
                </router-link>
            </div>
        </div>
        <el-form label-width="80px">
            <section class="post-body">
                <div class="post-body-main">
                    <div class="page-section">
                        <el-form-item :label="$t('post.title')">
                            <el-input type="text" size="medium" placeholder="" v-model="post.title"/>
                        </el-form-item>
                        <el-row :gutter="20">
                            <el-col :span="12">
                                <el-form-item :label="$t('common.url')">
                                    <el-input type="text" size="medium" v-model="post.slug">
                                        <span slot="prepend">{{siteUrl}}/</span>
                                    </el-input>
                                </el-form-item>
                            </el-col>
                            <el-col :span="12">
                                <el-form-item :label="$t('post.author')">
                                    <el-input type="text" size="medium" v-model="post.author"/>
                                </el-form-item>
                            </el-col>
                        </el-row>
                        <el-row :gutter="20">
                            <el-col :span="12">
                                <el-form-item :label="$t('post.allow_comment')">
                                    <el-switch active-value="1" inactive-value="0" v-model="post.allow_comment"/>
                                </el-form-item>
                            </el-col>
                            <el-col :span="12">
                                <el-form-item :label="$t('common.published_at')">
                                    <el-input type="text" size="medium" v-model="post.created_at"/>
                                </el-form-item>
                            </el-col>
                        </el-row>
                        <el-form-item :label="$t('common.keywords')">
                            <el-input type="text" size="medium" v-model="post.keywords"/>
                        </el-form-item>
                        <el-form-item :label="$t('common.excerpt')">
                            <el-input type="textarea" rows="5" v-model="post.description"/>
                        </el-form-item>
                        <el-form-item :label="$t('common.content')">
                            <wang-editor v-model="content.content"/>
                        </el-form-item>
                    </div>
                </div>
                <div class="post-body-box">
                    <div class="post-card">
                        <div class="post-card-header">
                            <h2>{{ $t('post.category') }}</h2>
                        </div>
                        <div class="post-card-body">
                            <div class="category-box">
                                <el-checkbox-group v-model="selectedCategories">
                                    <category-checkbox-list :categories="categories"/>
                                </el-checkbox-group>
                            </div>
                        </div>
                    </div>

                    <div class="post-card">
                        <div class="post-card-header">
                            <h2>{{ $t('post.featured_image') }}</h2>
                        </div>
                        <div class="post-card-body">
                            <div class="feature-image-box" @click="showMediaDialog=true">
                                <img :src="post.image" v-if="post.image" alt="">
                            </div>
                        </div>
                    </div>

                    <div class="post-card">
                        <div class="post-card-header">
                            <h2>{{ $t('post.attribute') }}</h2>
                        </div>
                        <div class="post-card-body">
                            <div class="form-label">{{ $t('post.format') }}</div>
                            <el-select size="medium" class="w-100" v-model="post.format">
                                <el-option v-for="(v,k) in formats" :value="k" :label="v" :key="k"/>
                            </el-select>
                            <div class="form-label">{{ $t('post.price') }}</div>
                            <div>
                                <el-input type="text" size="medium" class="w-100" v-model="post.price"/>
                            </div>
                            <div class="form-label">{{ $t('post.from') }}</div>
                            <div>
                                <el-input type="text" size="medium" class="w-100" v-model="post.from"/>
                            </div>
                            <div class="form-label">{{ $t('post.fromurl') }}</div>
                            <div>
                                <el-input type="text" size="medium" class="w-100" v-model="post.fromurl"/>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </el-form>

        <fixed-bottom slot="footer">
            <el-button @click="onSubmit('draft')" :disabled="disabled">{{ $t('common.save_draft') }}</el-button>
            <el-button type="primary" @click="onSubmit('publish')" :disabled="disabled">{{
                post.id ? $t('common.update') : $t('common.publish_now')
                }}
            </el-button>
        </fixed-bottom>
        <media-dialog v-model="showMediaDialog" :options="{type:'image'}" @confirm="onChooseImage"/>
    </main-layout>
</template>

<script>
import CategoryCheckboxList from "../components/CategoryCheckboxList";
import CategoryService from "../utils/CategoryService";
import PostService from "../utils/PostService";

export default {
    name: "PostEdit",
    components: {CategoryCheckboxList},
    data() {
        return {
            type: 'post',
            post: {},
            content: {},
            images: [],
            metas: [],
            categories: [],
            formats: [],
            selectedCategories: [],
            showMediaDialog: false,
            disabled: false,
            siteUrl: window.siteUrl || window.location.origin,
        }
    },
    methods: {
        fetchData() {
            let {id} = this.$route.params;
            PostService.get(id || 0).then(response => {
                this.post = response.data;
                const {content, images, media, categories} = this.post;
                this.selectedCategories = categories.map(c => c.id);
                if (content) this.content = content;
                if (images) this.images = images;
            });
        },
        fetchFormats() {
            PostService.get('formats').then(response => {
                this.formats = response.data;
            });
        },
        fetchCategories() {
            CategoryService.list({taxonomy: this.type}).then(response => {
                this.categories = response.data.items;
            });
        },
        onChooseImage(media) {
            this.post.image = media.src;
        },
        onSubmit(status) {
            let {post, content, images, media, selectedCategories, metas, type} = this;
            if (!post.title) {
                this.$message.error(this.$t('post.title_required'));
                return false;
            }

            post.status = status;
            post.content = content;
            post.images = images;
            post.metas = metas;
            post.categories = selectedCategories;

            this.disabled = true;
            if (post.id) {
                PostService.update(post.id, post).then(() => {
                    this.$message.success(this.$t('post.updated'));
                    this.fetchData();
                }).catch(reason => {
                    this.$message.error(reason.message);
                }).finally(() => {
                    this.disabled = false;
                });
            } else {
                post.type = type;
                PostService.store(post).then(res => {
                    this.$message.success(this.$t('post.saved'));
                    this.$router.replace('/post/edit/' + res.data.id);
                }).catch(reason => {
                    this.$message.error(reason.message);
                }).finally(() => {
                    this.disabled = false;
                });
            }
        }
    },
    created() {
        const {type} = this.$route.query;
        if (type) this.type = type;
    },
    mounted() {
        this.fetchData();
        this.fetchFormats();
        this.fetchCategories();
    },
}
</script>

<style scoped>

</style>
