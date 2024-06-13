<template>
    <main-layout>
        <div slot="header">
            <h2>店铺设置</h2>
        </div>
        <section v-loading="loading" class="page-section setting-form-wrapper">
            <el-form size="medium" label-width="160px">
                <el-form-item label="营业时间">
                    <el-time-select
                            placeholder="起始时间"
                            v-model="settings.opening_hours_start"
                            :picker-options="{
                      start: '00:00',
                      step: '00:15',
                      end: '23:59'
                    }">
                    </el-time-select>
                    <el-time-select
                            placeholder="结束时间"
                            v-model="settings.opening_hours_end"
                            :picker-options="{
                              start: '00:00',
                              step: '00:15',
                              end: '23:59',
                            }">
                    </el-time-select>
                    <div class="el-form-tips">选择店铺营业时间</div>
                </el-form-item>
                <el-form-item label="发送订单短信">
                    <el-switch v-model="settings.send_order_message" active-value="yes" inactive-value="no"/>
                </el-form-item>
                <el-form-item label="订单短信内容">
                    <el-input type="textarea" class="w500" rows="3" v-model="settings.order_message_content"/>
                    <div class="el-form-tips">新订单发送给客户的短信内容</div>
                </el-form-item>
                <el-form-item label="自动打印订单">
                    <el-switch
                            v-model="settings.auto_print_order"
                            active-value="yes"
                            inactive-value="no"
                    />
                    <div class="el-form-tips">是否自动打印订单</div>
                </el-form-item>
                <el-form-item label="开启积分结账">
                    <el-switch
                            v-model="settings.enable_points_checkout"
                            active-value="yes"
                            inactive-value="no"
                    />
                    <div class="el-form-tips">是否允许使用积分抵扣现金结账</div>
                </el-form-item>
                <el-form-item label="积分汇率">
                    <el-input class="w200" v-model="settings.points_exchange_rate"/>
                    <div class="el-form-tips">1个积分可抵扣的现金金额</div>
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