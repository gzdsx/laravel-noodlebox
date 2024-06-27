<template>
    <div class="lottery-chest">
        <div class="chest-rotate">
            <div class="chest-box">
                <div class="chest" :class="{'shake':shaking,'chest-open':isopend}"
                     @click.prevent="handlerLottery"></div>
            </div>
            <div class="chest-try-again" v-if="isopend">
                <button class="btn btn-safety-orange text-white" @click="handleTryAgain">Try again</button>
            </div>
        </div>
        <div class="lottery-overlayer" v-if="loading">
            <div class="spinner-border text-light" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>
</template>

<script>
import HttpClient from "../HttpClient";

export default {
    name: "LuckyBox",
    data() {
        return {
            shaking: false,
            isopend: false,
            loading: false,
            error: null
        }
    },
    methods: {
        handlerLottery() {
            if (this.isopend) {
                return;
            }

            this.shaking = true;
            setTimeout(() => {
                this.isopend = true;
                this.draw();
            }, 1300);
        },
        draw() {
            this.loading = true;
            HttpClient.get('/lottery/draw').then((res) => {
                setTimeout(() => {
                    this.$emit('draw', res.data);
                }, 1000);
            }).catch(reason => {
                this.setTimeout(() => {
                    this.$emit('error', reason);
                }, 1000);
            }).finally(() => {
                setTimeout(() => {
                    this.loading = false;
                }, 1000);
            });
        },
        handleTryAgain() {
            this.isopend = false;
            this.shaking = false;
        }
    }
}
</script>

<style scoped>

</style>