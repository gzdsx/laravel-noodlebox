<script>
export default {
    name: "NoodleOverlayer"
}
</script>

<template>
    <div class="noodle-overlayer" @click="$emit('click')">
        <slot/>
    </div>
</template>

<style lang="scss" scoped>
.noodle-overlayer {
    position: fixed;
    left: 0;
    top: 0;
    bottom: 0;
    right: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background-color: rgba(0, 0, 0, 0.3);
    z-index: 999;
}
</style>