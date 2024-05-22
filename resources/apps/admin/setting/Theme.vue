<template>
    <main-layout>
        <div slot="header">
            <h2>{{ $t('settings.general') }}</h2>
        </div>
        <section class="page-section setting-form-wrapper" v-loading="loading">
            <el-form size="medium" label-width="160px">
                <el-form-item :label="$t('settings.logo')">
                    <featured-image :src="settings.logo" @click="onShowDialog('logo')" width="120px" height="60px" fit="contain"/>
                    <div class="el-form-tips">{{ $t('settings.logo_tips') }}</div>
                </el-form-item>
                <el-form-item label="Favicon">
                    <featured-image :src="settings.favicon" @click="onShowDialog('favicon')" width="64px" height="64px" fit="contain"/>
                    <div class="el-form-tips">导航栏图标，尺寸128x128</div>
                </el-form-item>
                <el-form-item label="首页LOGO">
                    <featured-image :src="settings.home_page_logo" @click="onShowDialog('home_page_logo')" width="200px"
                                    height="100px" fit="contain"/>
                    <div class="el-form-tips">首页banner大LOGO</div>
                </el-form-item>
                <el-form-item label="首页Banner背景">
                    <el-input class="w500" v-model="settings.home_page_banner_src">
                        <el-button @click="onShowDialog('home_page_banner_src')" slot="append">选择视频</el-button>
                    </el-input>
                    <div class="el-form-tips">首页banner视频</div>
                </el-form-item>

                <el-form-item>
                    <el-button type="primary" size="medium" @click="onSubmit">{{ $t('settings.save') }}</el-button>
                </el-form-item>
            </el-form>
        </section>
        <media-dialog v-model="showMediaDialog" :options="{type:'image'}" @confirm="onChooseImage"/>
    </main-layout>
</template>

<script>
import SettingMixin from "./SettingMixin";

export default {
    name: "Theme",
    mixins: [SettingMixin],
    data() {
        return {
            key: '',
            showMediaDialog: false,
        }
    },
    methods: {
        onChooseImage(m) {
            if (this.key) {
                this.settings[this.key] = m.src;
            }
        },
        onShowDialog(key) {
            this.key = key;
            this.showMediaDialog = true;
        },
    }
}
</script>

<style scoped>

</style>