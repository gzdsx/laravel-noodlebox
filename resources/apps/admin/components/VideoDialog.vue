<template>
    <div>
        <el-dialog
                title="New Video"
                @close="onClose"
                :visible="visible"
                :close-on-click-modal="false"
                :close-on-press-escape="false"
        >
            <el-form label-width="100px" size="medium">
                <el-form-item label="Title">
                    <el-input class="w500" v-model="video.title"/>
                </el-form-item>
                <el-form-item label="Image">
                    <div class="img-100" @click="handleChooseImage">
                        <featured-image :src="video.image"/>
                    </div>
                </el-form-item>
                <el-form-item label="Video URL">
                    <el-input v-model="video.src">
                        <el-button slot="append" @click="handleChooseVideo">Choose Video</el-button>
                    </el-input>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="onSubmit">Submit</el-button>
                </el-form-item>
            </el-form>
        </el-dialog>
        <media-dialog v-model="showMaterialDialog" :options="materialOptions" @confirm="chooseMaterial"/>
    </div>
</template>

<script>
export default {
    name: "VideoDialog",
    props: {
        value: false,
        video: {
            type: Object,
            default() {
                return {}
            }
        }
    },
    data() {
        return {
            visible: false,
            showMaterialDialog: false,
            chooseMaterial: function () {

            },
            materialOptions: {type: 'image'}
        }
    },
    watch: {
        value(val) {
            if (val !== this.visible) {
                this.visible = val;
            }
        }
    },
    methods: {
        onClose() {
            this.$emit('input', false);
        },
        handleChooseVideo() {
            this.materialOptions = {type: 'video'};
            this.chooseMaterial = (m) => {
                if (!this.video.title) {
                    this.video.title = m.name;
                }

                if (!this.video.image) {
                    this.video.image = m.thumb;
                }

                this.video.src = m.url;
            }
            this.showMaterialDialog = true;
        },
        handleChooseImage(m) {
            this.materialOptions = {type: 'image'};
            this.chooseMaterial = (m) => {
                this.video.image = m.url;
            }
            this.showMaterialDialog = true;
        },
        onSubmit() {
            let {video} = this;
            if (!video.title) {
                this.$message.error('Please Enter Title');
                return false;
            }

            if (!video.src) {
                this.$message.error('Please Enter Video URL');
                return false;
            }
            this.$emit('submit', video);
        }
    },
    created() {
        this.visible = this.value;
    },
    mounted() {

    }
}
</script>

<style scoped>

</style>