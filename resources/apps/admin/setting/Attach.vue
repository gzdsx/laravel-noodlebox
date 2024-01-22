<template>
    <main-layout>
        <div slot="header">
            <h2>{{$t('settings.attach')}}</h2>
        </div>
        <section class="page-section">
            <el-form label-width="160px">
                <el-form-item :label="$t('settings.file_type_limit')">
                    <el-input type="text" class="w500" v-model="settings.file_allow_types"/>
                    <div class="el-form-tips">
                        {{$t('settings.file_type_limit_tips')}}
                    </div>
                </el-form-item>
                <el-form-item :label="$t('settings.file_size_limit')">
                    <el-input type="text" class="w200" v-model="settings.file_max_size"/>
                    <div class="el-form-tips">
                        {{$t('settings.file_size_limit_tips')}}
                    </div>
                </el-form-item>
                <el-form-item :label="$t('settings.image_type_limit')">
                    <el-input type="text" class="w500" v-model="settings.image_allow_types"/>
                    <div class="el-form-tips">
                        {{$t('settings.image_type_limit_tips')}}
                    </div>
                </el-form-item>
                <el-form-item :label="$t('settings.image_size_limit')">
                    <el-input type="text" class="w200" v-model="settings.image_max_size"/>
                    <div class="el-form-tips">
                        {{$t('settings.image_size_limit_tips')}}
                    </div>
                </el-form-item>
                <el-form-item :label="$t('settings.image_width_limit')">
                    <el-input type="text" class="w200" v-model="settings.image_max_width"/>
                    <div class="el-form-tips">
                        {{$t('settings.image_width_limit_tips')}}
                    </div>
                </el-form-item>
                <el-form-item :label="$t('settings.image_height_limit')">
                    <el-input type="text" class="w200" v-model="settings.image_max_height"/>
                    <div class="el-form-tips">
                        {{$t('settings.image_height_limit_tips')}}
                    </div>
                </el-form-item>
                <el-form-item :label="$t('settings.image_thumb_width')">
                    <el-input type="text" class="w200" v-model="settings.image_thumb_width"/>
                    <div class="el-form-tips">
                        {{$t('settings.image_thumb_height_tips')}}
                    </div>
                </el-form-item>
                <el-form-item :label="$t('settings.image_thumb_height')">
                    <el-input type="text" class="w200" v-model="settings.image_thumb_height"/>
                    <div class="el-form-tips">
                        {{$t('settings.image_thumb_height_tips')}}
                    </div>
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
    name: "Attach",
    mixins: [SettingMixin]
}
</script>

<style scoped>

</style>