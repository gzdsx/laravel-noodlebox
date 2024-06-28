<template>
    <div>
        <div class="form-group__label">Use Points</div>
        <div class="form-group__input">
            <div class="input-group" style="width: 300px;">
                <input type="number" class="form-control" v-model="points"/>
                <div class="input-group-append">
                    <button class="btn btn-danger" @click="handleSubmit">Use points</button>
                </div>
            </div>
        </div>
        <div class="text-turquoise mt-2">{{ pointsAccount.tips }}</div>
    </div>
</template>

<script>
import HttpClient from "../HttpClient";

export default {
    name: "CheckoutUsePoints",
    props: {
        subtotal: {
            type: Number|String,
            default: 0
        },
    },
    data() {
        return {
            points: 0,
            pointsAccount: {
                points: 0,
                tips: ''
            }
        }
    },
    methods: {
        handleSubmit() {
            let {subtotal, points} = this;
            HttpClient.post('/checkout/use-points', {subtotal, points}).then((response) => {
                this.points = response.data.points;
                this.$emit('change', {
                    points: response.data.points,
                    points_total: response.data.points_total
                });
            }).catch((error) => {
                console.log(error.message);
            });
        },
        fetchPointsAccount() {
            HttpClient.get('/my/points').then((response) => {
                this.pointsAccount = {
                    ...this.pointsAccount,
                    ...response.data
                };
            });
        },
    },
    mounted() {
        this.fetchPointsAccount();
    }
}
</script>

<style scoped>

</style>