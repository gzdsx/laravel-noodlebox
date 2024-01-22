<template>
    <main-layout>
        <div slot="header">
            <h2>{{ $t('settings.general') }}</h2>
        </div>
        <section class="page-section">
            <el-form label-width="160px">
                <el-form-item :label="$t('settings.logo')">
                    <div class="w120 bg-secondary" @click="onShowDialog('logo')">
                        <el-image :src="settings.logo" class="w120" fit="contain" v-if="settings.logo"/>
                        <div class="img-placeholder img-120" v-else></div>
                    </div>
                    <div class="el-form-tips">{{ $t('settings.logo_tips') }}</div>
                </el-form-item>
                <el-form-item :label="$t('settings.foot_logo')">
                    <div class="w120 bg-secondary" @click="onShowDialog('foot_logo')">
                        <el-image :src="settings.foot_logo" class="w120" fit="contain" v-if="settings.foot_logo"/>
                        <div class="img-placeholder img-120" v-else></div>
                    </div>
                    <div class="el-form-tips">{{ $t('settings.foot_logo_tips') }}</div>
                </el-form-item>
                <el-form-item :label="$t('settings.sitename')">
                    <el-input type="text" class="w500" v-model="settings.sitename"/>
                    <div class="el-form-tips">{{ $t('settings.sitename_tips') }}</div>
                </el-form-item>
                <el-form-item :label="$t('settings.keywords')">
                    <el-input type="text" class="w500" v-model="settings.keywords"/>
                    <div class="el-form-tips">
                        {{ $t('settings.keywords_tips') }}
                    </div>
                </el-form-item>
                <el-form-item :label="$t('settings.description')">
                    <el-input type="textarea" class="w500" rows="5" v-model="settings.description"/>
                    <div class="el-form-tips">{{ $t('settings.description_tips')}}</div>
                </el-form-item>
                <el-form-item :label="$t('settings.site_language')">
                    <el-select v-model="settings.language">
                        <el-option value="zh_CN" label="简体中文"/>
                        <el-option value="en" label="English"/>
                    </el-select>
                </el-form-item>
                <el-form-item :label="$t('settings.admin_email')">
                    <el-input class="w500" v-model="settings.admin_email"/>
                    <div class="el-form-tips">{{ $t('settings.admin_email_tips')}}</div>
                </el-form-item>
                <el-form-item :label="$t('settings.icp')">
                    <el-input type="text" class="w500" v-model="settings.icp"/>
                    <div class="el-form-tips">
                        {{$t('settings.icp_tips')}}
                    </div>
                </el-form-item>
                <el-form-item :label="$t('settings.copyright')">
                    <el-input type="text" class="w500" v-model="settings.copyright"/>
                    <div class="el-form-tips">{{ $t('settings.copyright_tips')}}</div>
                </el-form-item>
                <el-form-item :label="$t('settings.stats_code')">
                    <el-input type="textarea" class="w500" rows="8" v-model="settings.statcode"/>
                    <div class="el-form-tips">
                        {{$t('settings.stats_code_tips')}}
                    </div>
                </el-form-item>

                <el-form-item>
                    <el-button type="primary" size="medium" @click="onSubmit">{{ $t('settings.save')}}</el-button>
                </el-form-item>
            </el-form>
        </section>
        <media-dialog v-model="showMediaDialog" :options="{type:'image'}" @confirm="onChooseImage"/>
    </main-layout>
</template>

<script>
import SettingMixin from "./SettingMixin";

export default {
    name: "Basic",
    mixins: [SettingMixin],
    data() {
        return {
            key: '',
            showMediaDialog: false
        }
    },
    methods: {
        onChooseImage(m) {
            if (this.key) {
                this.settings[this.key] = m.url;
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