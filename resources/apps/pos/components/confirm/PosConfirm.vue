<template>
    <div class="gzdsx-pos-dialog__overlayer" v-show="show">
        <div class="gzdsx-pos-dialog gzdsx-pos-dialog__confirm">
            <div class="gzdsx-pos-dialog__body">
                <div class="gzdsx-pos-dialog__content">
                    <div class="gzdsx-pos-dialog__confirm__content" v-html="content"></div>
                    <button class="btn btn-info btn-block" @click="handleConfirm">{{ confirmText }}</button>
                    <button class="btn btn-secondary btn-block" @click="handleCancel" v-if="showCancel">{{ cancelText }}</button>
                </div>
            </div>
            <slot name="footer"/>
        </div>
    </div>
</template>

<script>
export default {
    name: "PosConfirm",
    data() {
        return {
            show: false,
            confirmText: 'Confirm',
            cancelText: 'Cancel',
            content: '',
            confirm: function () {

            },
            cancel: function () {

            },
            showCancel: false
        }
    },
    methods: {
        handleConfirm() {
            this.show = false;
            this.confirm && this.confirm();
        },
        handleCancel() {
            this.show = false;
            this.cancel && this.cancel();
        }
    }
}
</script>

<style scoped>

</style>