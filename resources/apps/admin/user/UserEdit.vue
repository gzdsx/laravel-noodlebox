<template>
    <main-layout>
        <h2 slot="header">{{ $t('user.edit') }}</h2>
        <div class="page-section">
            <el-form label-width="80px">
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
                    <el-input size="medium" class="w300" v-model="user.phone"/>
                    <div class="el-form-tips">{{ $t('user.phone_tips') }}</div>
                </el-form-item>
                <el-form-item :label="$t('user.email')">
                    <el-input size="medium" class="w300" v-model="user.email"/>
                    <div class="el-form-tips">{{ $t('user.email_tips') }}</div>
                </el-form-item>
                <el-form-item :label="$t('user.group')">
                    <el-select size="medium" class="w300" v-model="user.gid">
                        <el-option
                                v-for="(group,index) in groupList"
                                :label="group.name"
                                :value="group.gid"
                                :key="index"
                        />
                    </el-select>
                </el-form-item>
                <el-form-item>
                    <el-button size="medium" type="primary" @click="onSubmit">{{ $t('common.submit') }}</el-button>
                </el-form-item>
            </el-form>
        </div>
        <media-dialog v-model="showMediaDialog" :options="{width:500,fit:true,type:'image'}" @confirm="onChooseImage"/>
    </main-layout>
</template>

<script>
import UserService from "../utils/UserService";

export default {
    name: "UserEdit",
    data() {
        return {
            user: {},
            groupList: [],
            memberList: [],
            showMediaDialog: false
        }
    },
    methods: {
        fetchData() {
            let {uid} = this.$route.params;
            if (uid) {
                UserService.getUser(uid).then(response => {
                    this.user = response.result;
                });
            }
        },
        fetchGroupList() {
            UserService.listGroups().then(response => {
                this.groupList = response.result.items;
            });
        },
        onSubmit() {
            let {user} = this;
            if (!user.nickname) {
                this.$message.error(this.$t('user.nickname_required'));
                return false;
            }

            let {uid} = user;
            if (uid) {
                UserService.updateUser(uid, user).then(() => {
                    this.$message.success(this.$t('user.updated'));
                }).catch(reason => {
                    this.$message.error(reason.message);
                });
            } else {
                UserService.storeUser(user).then(res => {
                    this.$message.success(this.$t('user.saved'));
                    this.$router.replace('/user/edit/' + res.result.uid);
                }).catch(reason => {
                    this.$message.error(reason.message);
                });
            }
        },
        onChooseImage(m) {
            this.user.avatar = m.src;
        }
    },
    mounted() {
        this.fetchData();
        this.fetchGroupList();
    },
}
</script>

<style scoped>

</style>
