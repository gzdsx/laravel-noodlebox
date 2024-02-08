<template>
    <main-layout>
        <div slot="header">
            <h2>{{$t('settings.mail')}}</h2>
        </div>

        <section class="page-section setting-form-wrapper">
            <el-form label-width="160px">
                <el-form-item :label="$t('settings.mail_from_name')">
                    <el-input class="w300" v-model="settings.mail_from_name"/>
                </el-form-item>
                <el-form-item :label="$t('settings.mail_from_address')">
                    <el-input class="w300" v-model="settings.mail_from_address"/>
                </el-form-item>
                <el-form-item :label="$t('settings.mail_host')">
                    <el-input class="w300" v-model="settings.mail_host"/>
                </el-form-item>
                <el-form-item :label="$t('settings.mail_port')">
                    <el-input class="w100" v-model="settings.mail_port"/>
                </el-form-item>
                <el-form-item :label="$t('settings.mail_encryption')">
                    <el-radio-group v-model="settings.mail_encryption">
                        <el-radio label="">{{$t('settings.mail_encryption_none')}}</el-radio>
                        <el-radio label="ssl">{{$t('settings.mail_encryption_ssl')}}</el-radio>
                        <el-radio label="tls">{{$t('settings.mail_encryption_tls')}}</el-radio>
                    </el-radio-group>
                </el-form-item>
                <el-form-item :label="$t('settings.mail_username')">
                    <el-input class="w300" v-model="settings.mail_username"/>
                </el-form-item>
                <el-form-item :label="$t('settings.mail_password')">
                    <el-input type="password" class="w300" v-model="settings.mail_password"/>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" size="medium" @click="onSubmit">{{ $t('settings.save') }}</el-button>
                </el-form-item>
            </el-form>
        </section>
    </main-layout>
</template>

<script>
import SettingMixin from "./SettingMixin";

export default {
    name: "Mail",
    mixins: [SettingMixin]
}
</script>

<style scoped>

</style>