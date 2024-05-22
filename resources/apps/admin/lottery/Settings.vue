<template>
    <main-layout>
        <div slot="header">
            <h2>参数设置</h2>
        </div>
        <section class="page-section setting-form-wrapper">
            <el-form size="medium" label-width="160px">
                <el-form-item label="抽奖名称">
                    <el-input type="text" class="w500" v-model="settings.name"/>
                    <div class="el-form-tips">抽奖页面大标题</div>
                </el-form-item>
                <el-form-item label="规则介绍">
                    <el-input type="textarea" class="w500" rows="3" v-model="settings.description"/>
                    <div class="el-form-tips">抽奖规则和提示内容</div>
                </el-form-item>
                <el-form-item label="抽奖积分">
                    <el-input class="w500" v-model="settings.price"/>
                    <div class="el-form-tips">每次抽奖消耗的积分</div>
                </el-form-item>
                <el-form-item label="余额不足提示">
                    <el-input type="textarea" rows="3" class="w500" v-model="settings.insufficient_points"/>
                    <div class="el-form-tips">
                        当用户积分余额不足时的提示语
                    </div>
                </el-form-item>
                <el-form-item label="奖品库存文字">
                    <el-input class="w500" v-model="settings.stock_text"/>
                    <div class="el-form-tips">
                        前端显示剩余数量的文字
                    </div>
                </el-form-item>
                <el-form-item label="抽奖按钮文字">
                    <el-input class="w500" v-model="settings.button_text"/>
                </el-form-item>
                <el-form-item label="领奖按钮文字">
                    <el-input class="w500" v-model="settings.pick_text"/>
                    <div class="el-form-tips">领奖按钮文字</div>
                </el-form-item>
                <el-form-item label="中奖提示语">
                    <el-input class="w500" v-model="settings.winning_text"/>
                </el-form-item>
                <el-form-item label="未中奖提示语">
                    <el-input class="w500" v-model="settings.not_winning_text"/>
                </el-form-item>
                <el-form-item label="积分余额提示语">
                    <el-input class="w500" v-model="settings.points_balance_text"/>
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
import ApiService from "../utils/ApiService";

export default {
    name: "Settings",
    data() {
        return {
            settings: {},
            showMediaDialog: false,
            key: ''
        }
    },
    methods: {
        onChooseImage() {

        },
        onSubmit(){
            let {settings} = this;
            ApiService.post('/lottery/settings', {settings}).then(() => {
                this.$message.success(this.$t('settings.saved'));
            }).catch((reason) => {

            });
        }
    },
    mounted() {
        ApiService.get('/lottery/settings').then((res) => {
            this.settings = res.data;
        });
    }
}
</script>

<style scoped>

</style>