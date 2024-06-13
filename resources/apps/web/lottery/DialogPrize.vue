<template>
    <div class="lottery-overlayer" v-if="value">
        <div class="lottery-prize-dialog" :class="{'show':showDialog}">
            <h3 v-html="title"></h3>
            <div class="prize-image"><img :src="prize.image" alt=""></div>
            <p class="prize-name">{{ prize.name }}</p>
            <div>
                <button class="btn btn-bull-cyan btn-block text-white" @click="handlePickPrize"
                        v-html="buttonTitle"></button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "DialogPrize",
    props: {
        value: {
            type: Boolean,
            default: false
        },
        prize: {
            type: Object,
            default() {
                return {}
            }
        },
        title: {
            type: String,
            default: 'Congratulations'
        },
        buttonTitle: {
            type: String,
            default: '👆 Claim this prize now'
        }
    },
    data() {
        return {
            showDialog: false
        }
    },
    watch: {
        value(val) {
            if (val) {
                this.$nextTick(() => {
                    setTimeout(() => {
                        this.showDialog = true;
                    }, 20);
                });
            } else {
                this.showDialog = false;
            }
        }
    },
    methods: {
        handlePickPrize() {
            this.$emit('pick', this.prize);
        }
    }
}
</script>

<style scoped>

</style>