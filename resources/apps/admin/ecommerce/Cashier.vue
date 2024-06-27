<template>
    <main-layout>
        <div slot="header">
            <h2>收银台设置</h2>
        </div>
        <section v-loading="loading" class="page-section setting-form-wrapper">
            <el-form size="medium" label-width="160px">
                <el-form-item label="POS机">
                    <el-select v-model="settings.cashier_machine_id" placeholder="请选择">
                        <el-option
                                v-for="item in posMachines"
                                :key="item.id"
                                :label="item.name"
                                :value="item.id">
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="POS机余额">
                    <el-input class="w200" v-model="settings.cashier_amount"/>
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
import ApiService from "../utils/ApiService";

export default {
    name: "Cashier",
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
            posMachines: []
        }
    },
    methods: {
        onChooseImage() {

        },
        fetchPosMachines() {
            ApiService.get('/pos-machines').then(res => {
                this.posMachines = res.data.items;
            });
        },
    },
    mounted() {
        this.fetchPosMachines();
    }
}
</script>

<style scoped>

</style>