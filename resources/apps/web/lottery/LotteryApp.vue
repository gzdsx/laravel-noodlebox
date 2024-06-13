<template>
    <div>
        <div class="lottery-overlayer lottery-bg" v-if="showLottery">
            <div class="lottery-container">
                <div class="lottery-header">
                    <div class="h1" v-html="settings.name"></div>
                    <p v-html="settings.description"></p>
                    <p class="text-danger" v-html="error" v-if="error"></p>
                </div>
                <div class="lottery-game-box">
                    <lucky-box @draw="onDraw" @error="onError" v-if="settings.lottery_type==='chest'"/>
                    <lottery-turntable @draw="onDraw" @error="onError" v-else/>
                </div>
                <dialog-prize
                        :prize="prize"
                        :title="settings.winning_text"
                        :button-title="settings.pick_text"
                        v-model="showPrize"
                        @pick="onPickPrize"
                />
            </div>
            <span class="lottery-close" @click="showLottery=false">close</span>
        </div>
        <lottery-loading v-if="loading"/>
        <dialog-lottery-cart v-model="showCart"/>
        <div class="lottery-win-points" v-if="showPoints">+{{ prize.points }}</div>
        <div class="lottery-float" v-if="settings.enable==='yes'">
            <img :src="settings.float_icon" alt="" @click="showLottery=true"/>
        </div>
    </div>
</template>

<script>
import HttpClient from "../HttpClient";
import LuckyBox from "./LuckyBox.vue";
import DialogPrize from "./DialogPrize.vue";
import LotteryLoading from "./LotteryLoading.vue";
import DialogLotteryCart from "./DialogLotteryCart.vue";
import LotteryTurntable from "./LotteryTurntable.vue";

export default {
    name: "LotteryApp",
    components: {LotteryTurntable, DialogLotteryCart, LotteryLoading, DialogPrize, LuckyBox},
    data() {
        return {
            settings: {},
            prize: {},
            showPrize: false,
            loading: false,
            showPoints: false,
            showCart: false,
            showLottery: false,
            error: null
        }
    },
    methods: {
        fetchSettings() {
            HttpClient.get('/lottery/settings').then((res) => {
                this.settings = res.data;
            }).catch(reason => {

            });
        },
        onDraw(prize) {
            this.prize = prize;
            this.showPrize = true;
        },
        onError(reason){
            this.error = reason.message;
        },
        onPickPrize(prize) {
            this.showPrize = false;
            if (prize.type === 'point') {
                this.showPoints = true;
                setTimeout(() => {
                    this.showPoints = false;
                }, 2000);
            } else {
                this.showCart = true;
            }
        }
    },
    created() {
        this.fetchSettings();
        document.querySelector('[data-show-lottery]').addEventListener('click', () => {
            this.showLottery = true;
        });
    },
}
</script>

<style scoped>

</style>