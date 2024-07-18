<script>
import ApiService from "../utils/ApiService";
import RoleEdit from "./RoleEdit.vue";

export default {
    name: "Roles",
    components: {RoleEdit},
    data() {
        return {
            loading: true,
            dataList: [],
            showDialog: false
        }
    },
    methods: {
        fetchList() {
            this.loading = true;
            ApiService.get('/roles').then(response => {
                this.dataList = response.data.items;
            }).catch(reason => {
                this.$message.error(reason.message);
            }).finally(() => {
                this.loading = false;
            });
        },
        onShowAdd(){
            this.showDialog = true;
        }
    }
}
</script>

<template>
    <main-layout>
        <div class="d-flex" slot="header">
            <div class="header-left">
                <h2>{{ $t('user.group') }}</h2>
            </div>
            <div>
                <el-button size="small" type="primary" @click="onShowAdd">{{ $t('user.add_group') }}</el-button>
            </div>
        </div>
        <section class="page-section">

        </section>
        <role-edit v-model="showDialog"/>
    </main-layout>
</template>

<style scoped>

</style>