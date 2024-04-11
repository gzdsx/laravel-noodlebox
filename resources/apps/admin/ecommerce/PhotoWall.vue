<template>
    <main-layout>
        <div class="d-flex" slot="header">
            <h2 class="header-left">照片墙</h2>
            <div class="header-right">
                <el-button type="primary" size="small" @click="showDialog=true">添加照片</el-button>
            </div>
        </div>
        <section class="page-section">
            <div class="photo-walls">
                <div class="photo-item" v-for="(item,index) in dataList" :key="index">
                    <el-image :src="item.thumb" class="photo-item__image" fit="cover"/>
                </div>
            </div>
        </section>
        <media-dialog multiple="multiple" :options="options" :maxCount="200" v-model="showDialog"
                      @confirm="onSelectedFiles"/>
    </main-layout>
</template>

<script>
import ApiService from "../utils/ApiService";

export default {
    name: "PhotoWall",
    data() {
        return {
            loading: false,
            showDialog: false,
            dataList: [],
            options: {type: 'image'}
        }
    },
    methods: {
        fetchList() {
            this.loading = true;
            let {offset, limit, params} = this;
            ApiService.get('/photo-walls').then(response => {
                this.dataList = response.data.items;
            });
        },
        onSelectedFiles(files) {
            let photos = files.map(file => {
                return {
                    title: file.name,
                    description: file.description,
                    thumb: file.thumb,
                    image: file.src
                }
            });

            ApiService.post('/photo-walls/batch', {photos}).then(response => {
                this.fetchList();
            });
        }
    },
    mounted() {
        this.fetchList();
    }
}
</script>

<style scoped>

</style>