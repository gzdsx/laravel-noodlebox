<template>
    <div :style="{width: width, height: height}" @click="onClick">
        <el-image :src="src" :fit="fit" class="image">
            <div slot="error" class="image-slot">
                <i class="el-icon-picture-outline"></i>
            </div>
        </el-image>
    </div>
</template>

<script>
export default {
    name: "FeaturedImage",
    props: {
        src: {
            type: String,
            default: ''
        },
        fit: {
            type: String,
            default: 'cover'
        },
        width: {
            type: String,
            default: '100px'
        },
        height: {
            type: String,
            default: '100px'
        },
    },
    data() {
        return {}
    },
    methods: {
        onClick() {
            this.$emit('click', {src: this.image});
        }
    }
}
</script>

<style scoped>
.image {
    width: 100%;
    height: 100%;
}

.image-slot {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 100%;
    background: #f5f7fa;
    color: #909399;
    font-size: 14px;
}

.el-icon-picture-outline {
    font-size: 30px;
}
</style>