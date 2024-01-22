<template>
    <main-layout>
        <div slot="header">
            <h2>{{ $t('settings.register') }}</h2>
        </div>
        <section class="page-section">
            <el-form label-width="160px">
                <el-form-item :label="$t('settings.register_allowed')">
                    <el-switch :active-value="1" :inactive-value="0" v-model="settings.regallowed"/>
                </el-form-item>
                <el-form-item :label="$t('settings.register_verify')">
                    <el-select class="w200" v-model="settings.regverify">
                        <el-option :value="0" :label="$t('settings.register_verify_none')"/>
                        <el-option :value="1" :label="$t('settings.register_verify_email')"/>
                        <el-option :value="2" :label="$t('settings.register_verify_manual')"/>
                    </el-select>
                    <div class="el-form-tips">
                        {{ $t('settings.register_verify_tips') }}
                    </div>
                </el-form-item>
                <el-form-item :label="$t('settings.register_send_wellcome')">
                    <el-switch :active-value="1" :inactive-value="0" v-model="settings.send_wellcome_msg"/>
                </el-form-item>
                <el-form-item :label="$t('settings.register_show_license')">
                    <el-switch :active-value="1" :inactive-value="0" v-model="settings.sysrules"/>
                </el-form-item>
                <el-form-item :label="$t('settings.register_license_content')">
                    <el-input type="textarea" class="w600" rows="10" v-model="settings.sysrulestxt"/>
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
    name: "Register",
    mixins: [SettingMixin]
}
</script>

<style scoped>

</style>