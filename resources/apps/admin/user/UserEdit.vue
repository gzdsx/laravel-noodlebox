<template>
    <main-layout>
        <h2 slot="header">{{ $t('user.edit') }}</h2>
        <div class="page-section">
            <el-form label-width="80px" size="medium">
                <el-form-item :label="$t('user.avatar')">
                    <div class="img-60" @click="showMediaDialog=true">
                        <img :src="user.avatar" class="img-60" v-if="user.avatar" alt=""/>
                        <div class="img-60 img-placeholder" v-else></div>
                    </div>
                    <div class="el-form-tips">{{ $t('user.avatar_tips') }}</div>
                </el-form-item>
                <el-form-item :label="$t('user.nickname')">
                    <el-input size="medium" class="w300" v-model="user.nickname"/>
                    <div class="el-form-tips">{{ $t('user.nickname_tips') }}</div>
                </el-form-item>
                <el-form-item :label="$t('user.password')">
                    <el-input size="medium" class="w300" type="password" v-model="user.password"/>
                    <div class="el-form-tips">{{ $t('user.password_tips') }}</div>
                </el-form-item>
                <el-form-item :label="$t('user.phone')">
                    <el-input size="medium" class="w300" v-model="user.phone_number">
                        <el-select class="w90" v-model="user.national_number" placeholder="" slot="prepend">
                            <el-option value="353" label="+353"/>
                            <el-option value="44" label="+44"/>
                            <el-option value="86" label="+86"/>
                        </el-select>
                    </el-input>
                    <div class="el-form-tips">{{ $t('user.phone_tips') }}</div>
                </el-form-item>
                <el-form-item :label="$t('user.email')">
                    <el-input size="medium" class="w300" v-model="user.email"/>
                    <div class="el-form-tips">{{ $t('user.email_tips') }}</div>
                </el-form-item>
                <el-form-item :label="$t('user.role')">
                    <el-select size="medium" class="w300" v-model="meta_data.capability">
                        <el-option
                            v-for="(v,k) in roles"
                            :label="v"
                            :value="k"
                            :key="k"
                        />
                    </el-select>
                </el-form-item>
                <el-form-item>
                    <el-button :loading="loading" type="primary" @click="onSubmit">{{ $t('common.submit') }}</el-button>
                </el-form-item>
            </el-form>
        </div>
        <media-dialog v-model="showMediaDialog" :options="{width:500,fit:true,type:'image'}" @confirm="onChooseImage"/>
    </main-layout>
</template>

<script>
import UserService from "../utils/UserService";
import ApiService from "../utils/ApiService";

export default {
    name: "UserEdit",
    data() {
        return {
            user: {
                id: '',
                nickname: '',
                avatar: '',
                email: '',
                phone_number: '',
                national_number: '353'
            },
            meta_data: {
                capability: 'user'
            },
            roles: [],
            showMediaDialog: false,
            loading: false
        }
    },
    methods: {
        fetchData() {
            let {id} = this.$route.params;
            if (id) {
                UserService.getUser(id).then(response => {
                    this.user = {
                        ...this.user,
                        ...response.data
                    };
                    this.meta_data = {
                        ...this.meta_data,
                        ...response.data.meta_data
                    }
                });
            }
        },
        fetchGroupList() {
            UserService.listGroups().then(response => {
                this.groupList = response.data.items;
            });
        },
        onSubmit() {
            let {user, meta_data} = this;
            if (!user.nickname) {
                this.$message.error(this.$t('user.nickname_required'));
                return false;
            }

            this.loading = true;
            if (user.id) {
                UserService.updateUser(user.id, {
                    ...user,
                    meta_data
                }).then(() => {
                    this.$message.success(this.$t('user.updated'));
                }).catch(reason => {
                    this.$message.error(reason.message);
                }).finally(() => {
                    this.loading = false;
                });
            } else {
                UserService.storeUser(user).then(res => {
                    this.$message.success(this.$t('user.saved'));
                    this.$router.replace('/user/edit/' + res.data.uid);
                }).catch(reason => {
                    this.$message.error(reason.message);
                }).finally(() => {
                    this.loading = false;
                });
            }
        },
        onChooseImage(m) {
            this.user.avatar = m.src;
        },
        fetchOptions() {
            ApiService.get('/users/options').then(response => {
                this.roles = response.data.role_options;
            });
        }
    },
    mounted() {
        this.fetchData();
        this.fetchOptions();
    },
}
</script>

<style scoped>

</style>
