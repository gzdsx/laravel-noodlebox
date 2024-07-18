<script>
import ApiService from "../utils/ApiService";

export default {
    name: "RoleEdit",
    props: {
        value: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            role: {
                name: '',
                identifier: '',
                permissions: []
            },
            permissions: [],
            loading: false
        }
    },
    mounted() {

    },
    methods: {
        onSubmit() {
            let {id} = this.role;
            if (id) {
                this.loading = true;
                ApiService.put('/roles/' + id, this.role).then(() => {
                    this.$message.success('Role updated');
                    this.$emit('input', false);
                }).finally(() => {
                    this.loading = false;
                });
            } else {
                ApiService.post('/roles', this.role).then(() => {
                    this.$message.success('Role created');
                    this.$emit('input', false);
                }).finally(() => {
                    this.loading = false;
                });
            }
        }
    }
}
</script>

<template>
    <el-dialog
        title="Edit Role"
        :visible.sync="value"
        :close-on-click-modal="false"
        :close-on-press-escape="false"
        closeable
        @close="$emit('input', false)"
    >
        <el-form size="medium" label-width="160px">
            <el-form-item label="Name">
                <el-input class="w200" v-model="role.name"/>
            </el-form-item>
            <el-form-item label="Identifier">
                <el-input class="w200" v-model="role.identifier"/>
            </el-form-item>
            <el-form-item label="Permissions">
                <el-checkbox label="*">Grant All</el-checkbox>
                <el-checkbox-group v-model="role.permissions">
                    <el-checkbox v-for="permission in permissions" :key="permission.id" :label="permission.id">
                        {{ permission.name }}
                    </el-checkbox>
                </el-checkbox-group>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" :loading="loading" @click="onSubmit">Submit</el-button>
            </el-form-item>
        </el-form>
    </el-dialog>
</template>

<style scoped>

</style>