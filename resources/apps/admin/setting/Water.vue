<template>
    <main-layout>
        <div slot="header">
            <h2>{{ $t('settings.watermark') }}</h2>
        </div>
        <section class="page-section setting-form-wrapper" v-loading="loading">
            <el-form label-width="160px">
                <el-form-item :label="$t('settings.watermark_enable')">
                    <el-switch :active-value="1" :inactive-value="0" v-model="settings.water_mark"/>
                </el-form-item>
                <el-form-item :label="$t('settings.watermark_type')">
                    <el-radio-group v-model="settings.water_type">
                        <el-radio label="image">{{ $t('settings.watermark_type_image') }}</el-radio>
                        <el-radio label="text">{{ $t('settings.watermark_type_text') }}</el-radio>
                    </el-radio-group>
                </el-form-item>
                <el-form-item :label="$t('settings.watermark_font')">
                    <el-input type="text" class="w300" v-model="settings.water_font"/>
                    <div class="el-form-tips">{{ $t('settings.watermark_font_tips') }}</div>
                </el-form-item>
                <el-form-item :label="$t('settings.watermark_image')">
                    <el-input type="text" class="w300" v-model="settings.water_image"/>
                    <div class="el-form-tips">{{ $t('settings.watermark_image_tips') }}</div>
                </el-form-item>
                <el-form-item :label="$t('settings.watermark_pos')">
                    <el-select class="w200" v-model="settings.water_pos">
                        <el-option value="top-left" :label="$t('settings.watermark_pos_top_left')"/>
                        <el-option value="top-center" :label="$t('settings.watermark_pos_top_center')"/>
                        <el-option value="top-right" :label="$t('settings.watermark_pos_top_right')"/>
                        <el-option value="left" :label="$t('settings.watermark_pos_left')"/>
                        <el-option value="center" :label="$t('settings.watermark_pos_center')"/>
                        <el-option value="right" :label="$t('settings.watermark_pos_right')"/>
                        <el-option value="bottom-left" :label="$t('settings.watermark_pos_bottom_left')"/>
                        <el-option value="bottom-center" :label="$t('settings.watermark_pos_bottom_center')"/>
                        <el-option value="bottom-right" :label="$t('settings.watermark_pos_bottom_right')"/>
                    </el-select>
                </el-form-item>
                <el-form-item :label="$t('settings.watermark_alpha')">
                    <el-input type="text" class="w200" v-model="settings.water_alpha"/>
                    <div class="el-form-tips">{{ $t('settings.watermark_alpha_tips') }}</div>
                </el-form-item>
                <el-form-item :label="$t('settings.watermark_text')">
                    <el-input type="textarea" class="w300" rows="3" v-model="settings.water_text"/>
                    <div class="el-form-tips">{{ $t('settings.watermark_text_tips') }}</div>
                </el-form-item>
                <el-form-item :label="$t('settings.watermark_fontcolor')">
                    <el-input type="text" class="w200" v-model="settings.water_fontcolor"/>
                    <div class="el-form-tips">{{ $t('settings.watermark_fontcolor_tips') }}</div>
                </el-form-item>
                <el-form-item :label="$t('settings.watermark_fontsize')">
                    <el-input type="text" class="w200" v-model="settings.water_fontsize"/>
                    <div class="el-form-tips">{{ $t('settings.watermark_fontsize_tips') }}</div>
                </el-form-item>
                <el-form-item :label="$t('settings.watermark_offset_x')">
                    <el-input type="text" class="w200" v-model="settings.water_offset_x"/>
                    <div class="el-form-tips">{{ $t('settings.watermark_offset_x_tips') }}</div>
                </el-form-item>
                <el-form-item :label="$t('settings.watermark_offset_y')">
                    <el-input type="text" class="w200" v-model="settings.water_offset_y"/>
                    <div class="el-form-tips">{{ $t('settings.watermark_offset_y_tips') }}</div>
                </el-form-item>
                <el-form-item :label="$t('settings.watermark_angle')">
                    <el-input type="text" class="w200" v-model="settings.water_angle"/>
                    <div class="el-form-tips">{{ $t('settings.watermark_angle_tips') }}</div>
                </el-form-item>

                <el-form-item>
                    <el-button type="primary" size="medium" @click="onSubmit">{{ $t('settings.save') }}
                    </el-button>
                </el-form-item>
            </el-form>
        </section>
    </main-layout>
</template>

<script>
import SettingMixin from "./SettingMixin";

export default {
    name: "Water",
    mixins: [SettingMixin]
}
</script>

<style scoped>

</style>