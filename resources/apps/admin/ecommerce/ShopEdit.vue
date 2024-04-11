<template>
    <main-layout>
        <div class="d-flex" slot="header">
            <h2>编辑门店</h2>
        </div>
        <section class="page-section">
            <el-form ref="form" size="medium" label-width="80px">
                <el-form-item label="门店标志">
                    <div class="img-120" @click="selectLogo">
                        <featured-image :src="shop.logo"/>
                    </div>
                </el-form-item>
                <el-form-item label="店铺名称">
                    <el-input class="w500" v-model="shop.name"/>
                </el-form-item>
                <el-form-item label="店铺地址">
                    <el-input class="w500" readonly v-model="region" @focus="showMap=true"/>
                </el-form-item>
                <el-form-item label="详细地址">
                    <el-input class="w500" v-model="shop.address_1"/>
                </el-form-item>
                <el-form-item label="店内照片">
                    <vuedraggable class="dsxui-uploader" v-model="images" draggable=".draggable">
                        <div class="dsxui-uploader-item draggable"
                             v-for="(img,idx) in images"
                             :key="idx"
                        >
                            <el-image :src="img.thumb" fit="cover"/>
                            <div class="bi bi-x del-icon" @click.stop="images.splice(idx,1)"/>
                        </div>
                        <div class="dsxui-uploader-button" @click.stop="selectImage" v-if="images.length<10">
                            <i class="el-icon-plus dsxui-uploader-icon"></i>
                        </div>
                    </vuedraggable>
                    <p>建议尺寸：800*800像素，拖拽图片可以调整顺序，最多上传10张。</p>
                </el-form-item>
                <el-form-item label="门店介绍">
                    <el-input type="textarea" class="w500" rows="10" v-model="shop.description"/>
                </el-form-item>
            </el-form>
        </section>
        <fixed-bottom>
            <el-button class="w100" @click="$router.go(-1)">取消</el-button>
            <el-button class="w100" type="primary" @click="onSubmit">保存</el-button>
        </fixed-bottom>
        <media-dialog
                v-model="showImagePicker"
                @confirm="onChooseImage"
                :multiple="mutipleMedia"
                :options="mediaPickerOptions"
        />
        <location-dialog v-model="showMap" @confirm="onChooseLocation"/>
    </main-layout>
</template>

<script>
import ShopService from "../utils/ShopService";

export default {
    name: "ShopEdit",
    data() {
        return {
            shop: {},
            images: [],
            region: '',
            showMap: false,
            showImagePicker: false,
            maxImageCount: 10,
            mutipleMedia: false,
            selectedMedia: function (images) {
            },
            mediaPickerOptions: {
                'width': 500,
                'fit': true
            },
            onChooseImage(images) {
            },
        }
    },
    methods: {
        fetchData() {
            let {id} = this.$route.params;
            if (id) {
                ShopService.getShop(id).then(response => {
                    this.shop = response.data;
                    let {province, city, district, images} = response.data;
                    this.region = province + city + district;
                    this.images = images;
                });
            }
        },
        onSubmit() {
            let {shop, images} = this;
            if (!shop.name) {
                this.$message.error('请填写店铺名称');
                return false
            }

            shop.images = images;
            let {id} = this.$route.params;
            if (id) {
                ShopService.updateShop(id, shop).then(() => {
                    this.$message.success('店铺已更新');
                    this.$router.history.go(0);
                });
            } else {
                ShopService.storeShop(shop).then(response => {
                    this.$message.success('店铺已保存');
                    this.$router.replace('/shop/edit/' + response.data.id);
                });
            }
        },
        onChooseLocation(position) {
            let {shop} = this;
            let {province, city, district, street, street_number} = position;
            this.region = province + city + district;
            this.showMap = false;
            this.shop = {
                ...shop,
                ...position
            }
        },
        selectLogo() {
            this.mutipleMedia = false;
            this.showImagePicker = true;
            this.mediaPickerOptions = {'width': 500, 'fit': true}
            this.onChooseImage = image => {
                this.shop.logo = image.src;
            }
        },
        selectImage() {
            this.mutipleMedia = true;
            this.showImagePicker = true;
            this.mediaPickerOptions = {};
            this.onChooseImage = images => {
                images.map(img => {
                    if (this.images.length < this.maxImageCount) {
                        this.images.push({
                            id: 0,
                            thumb: img.thumb,
                            image: img.src
                        });
                    }
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
