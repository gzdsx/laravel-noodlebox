<template>
    <main-layout>
        <div slot="header">
            <h2>{{ $t('shop.settings') }}</h2>
        </div>
        <section v-loading="loading" class="page-section setting-form-wrapper">
            <el-form size="medium" label-width="160px">
                <el-form-item :label="$t('shop.opening_hours')">
                    <el-time-select
                        v-model="settings.opening_hours_start"
                        :picker-options="{
                      start: '00:00',
                      step: '00:15',
                      end: '23:59'
                    }">
                    </el-time-select>
                    <el-time-select
                        v-model="settings.opening_hours_end"
                        :picker-options="{
                              start: '00:00',
                              step: '00:15',
                              end: '23:59',
                            }">
                    </el-time-select>
                    <div class="el-form-tips">{{ $t('shop.opening_hours_tips') }}</div>
                </el-form-item>
                <el-form-item :label="$t('shop.send_order_sms')">
                    <el-switch v-model="settings.send_order_message" active-value="yes" inactive-value="no"/>
                </el-form-item>
                <el-form-item :label="$t('shop.order_sms_content')">
                    <el-input type="textarea" class="w500" rows="3" v-model="settings.order_message_content"/>
                    <div class="el-form-tips">{{ $t('shop.order_sms_content_tips') }}</div>
                </el-form-item>
                <el-form-item :label="$t('shop.auto_print_order')">
                    <el-switch
                        v-model="settings.auto_print_order"
                        active-value="yes"
                        inactive-value="no"
                    />
                    <div class="el-form-tips">{{ $t('shop.auto_print_order_tips') }}</div>
                </el-form-item>
                <el-form-item :label="$t('shop.enable_points_checkout')">
                    <el-switch
                        v-model="settings.enable_points_checkout"
                        active-value="yes"
                        inactive-value="no"
                    />
                    <div class="el-form-tips">{{ $t('shop.enable_points_checkout_tips') }}</div>
                </el-form-item>
                <el-form-item :label="$t('shop.points_exchange_rate')">
                    <el-input class="w200" v-model="settings.points_exchange_rate"/>
                    <div class="el-form-tips">{{ $t('shop.points_exchange_rate_tips') }}</div>
                </el-form-item>
                <el-form-item :label="$t('shop.referral_points')">
                    <el-input class="w200" v-model="settings.referral_points"/>
                    <div class="el-form-tips">{{ $t('shop.referral_points_tips') }}</div>
                </el-form-item>
                <el-form-item :label="$t('shop.referral_link_description')">
                    <el-input type="textarea" rows="3" class="w500" v-model="settings.referral_link_description"/>
                    <div class="el-form-tips">{{ $t('shop.referral_link_description_tips')}}</div>
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
import SettingMixin from "../setting/SettingMixin";

export default {
    name: "Settings",
    mixins: [SettingMixin],
    data() {
        return {
            settings: {
                opening_hours_start: '08:00',
                opening_hours_end: '22:00',
                auto_print_order: 'yes',
                enable_points_checkout: 'yes'
            },
            showMediaDialog: false,
            key: '',
        }
    },
    methods: {
        onChooseImage() {

        },
    },
    mounted() {

    }
}
</script>

<style scoped>

</style>