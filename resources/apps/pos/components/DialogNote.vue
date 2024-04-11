<template>
    <pos-dialog title="Add Note" width="40%" :visible="value" @close="close">
        <div class="gzdsx-pos-dialog__content">
            <div class="form-group">
                <div class="form-input-label">Add a note to this order</div>
                <div>
                    <textarea class="form-control" rows="5" v-model="content"></textarea>
                </div>
            </div>
            <div class="form-group">
                <button type="button" role="button" class="btn btn-info btn-block text-uppercase" @click="submit">save note
                </button>
            </div>
        </div>
    </pos-dialog>
</template>

<script>
export default {
    name: "DialogNote",
    props: {
        value: Boolean,
    },
    data() {
        return {
            content: ''
        }
    },
    methods: {
        close() {
            this.$emit('input', false);
        },
        submit() {
            this.$emit('submit', this.content);
            this.$emit('input', false);
        }
    }
}
</script>

<style scoped>

</style>