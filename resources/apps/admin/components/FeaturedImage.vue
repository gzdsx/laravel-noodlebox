<template>
    <el-image :src="src" :fit="fit" class="image">
        <div slot="error" class="image-slot">
            <i class="el-icon-picture-outline"></i>
        </div>
    </el-image>
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