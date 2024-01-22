<template>
    <main-layout>
        <div slot="header">
            <h2>{{$t('settings.sterling')}}</h2>
        </div>
        <section class="page-section">
            <el-form label-width="160px">
                <el-form-item :label="$t('settings.listing_email')">
                    <el-input class="w500" v-model="settings.listing_email"/>
                    <div class="el-form-tips">{{ $t('settings.listing_email_tips')}}</div>
                </el-form-item>
                <el-form-item :label="$t('settings.contact_email')">
                    <el-input class="w500" v-model="settings.contact_email"/>
                    <div class="el-form-tips">{{$t('settings.contact_email_tips')}}</div>
                </el-form-item>
                <el-form-item :label="$t('settings.joinus_email')">
                    <el-input class="w500" v-model="settings.joinus_email"/>
                    <div class="el-form-tips">{{$t('settings.joinus_email_tips')}}</div>
                </el-form-item>
                <el-form-item :label="$t('settings.rfp_email')">
                    <el-input class="w500" v-model="settings.rfp_email"/>
                    <div class="el-form-tips">{{$t('settings.rfp_email_tips')}}</div>
                </el-form-item>
                <el-form-item :label="$t('settings.mail_message')">
                    <el-input type="textarea" rows="5" class="w500" v-model="settings.mail_message"/>
                    <div class="el-form-tips">{{$t('settings.mail_message_tips')}}</div>
                </el-form-item>
                <el-form-item :label="$t('settings.google_apikey')">
                    <el-input type="text" class="w500" v-model="settings.google_apikey"/>
                </el-form-item>

                <el-form-item>
                    <el-button type="primary" size="medium" @click="onSubmit">{{$t('settings.save')}}</el-button>
                </el-form-item>
            </el-form>
        </section>
    </main-layout>
</template>

<script>
import SettingMixin from "./SettingMixin";

export default {
    name: "Sterling",
    mixins: [SettingMixin]
}
</script>

<style scoped>

</style>