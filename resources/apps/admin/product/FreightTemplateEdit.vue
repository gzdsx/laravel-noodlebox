<template>
    <main-layout>
        <div class="d-flex" slot="header">
            <h2>编辑模板</h2>
        </div>

        <section class="page-section">
            <table class="dsxui-formtable">
                <colgroup>
                    <col class="w80">
                    <col>
                </colgroup>
                <tbody>
                <tr>
                    <td>模板名称</td>
                    <td>
                        <el-input size="medium" class="w300" v-model="template.template_name"></el-input>
                    </td>
                </tr>
                <tr>
                    <td>计价方式</td>
                    <td>
                        <el-radio :label="1" v-model="template.valuation">按件数</el-radio>
                        <el-radio :label="2" v-model="template.valuation">按重量(KG)</el-radio>
                    </td>
                </tr>
                <tr>
                    <td>默认运费</td>
                    <td>
                        <div class="display-flex align-items-center">
                            <el-input size="medium" class="w80" v-model="template.start_quantity"></el-input>
                            <div>{{ template.valuation === 1 ? '件' : 'KG' }}内</div>
                            <el-input size="medium" class="w80" v-model="template.start_fee"></el-input>
                            <div>元;每增加</div>
                            <el-input size="medium" class="w80" v-model="template.growth_quantity"></el-input>
                            <div>{{ template.valuation === 1 ? '件' : 'KG' }}</div>
                            <el-input size="medium" class="w80" v-model="template.growth_fee"></el-input>
                            <div>元</div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>包邮条件</td>
                    <td>
                        <div class="display-flex align-items-center">
                            <el-input size="medium" class="w80" v-model="template.free_quantity"></el-input>
                            <div>{{ template.valuation === 1 ? '件' : 'KG' }}以上包邮或者金额满</div>
                            <el-input size="medium" class="w80" v-model="template.free_amount"></el-input>
                            <div>以上包邮</div>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </section>
        <fixed-bottom>
            <el-button @click="$router.go(-1)" class="w100">取消</el-button>
            <el-button type="primary" @click="onSubmit" class="w100">保存</el-button>
        </fixed-bottom>
    </main-layout>
</template>

<script>
import ApiService from "../utils/ApiService";

export default {
    name: "FreightTemplateEdit",
    data() {
        return {
            template: {
                valuation: 1
            }
        }
    },
    methods: {
        fetchData() {
            let {template_id} = this.$route.params;
            if (!template_id) return;
            ApiService.get('/freight-templates/' + template_id).then(response => {
                this.template = response.result;
            });
        },
        onSubmit() {
            let {template} = this;
            if (!template.template_name) {
                this.$message.error('请填写模板名称');
                return false;
            }
            let {template_id} = this.$route.params;
            if (template_id) {
                ApiService.put('/freight-templates/' + template_id, {template}).then(() => {
                    this.$message.success('模板已更新');
                });
            } else {
                ApiService.post('/freight-templates', {template}).then(response => {
                    this.$message.success('模板已保存');
                    this.$router.replace('/freight-template/edit/' + response.result.template_id);
                });
            }
        }
    },
    mounted() {
        this.fetchData();
    },
}
</script>

<style scoped>

</style>
