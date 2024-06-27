<template>
    <div>
        <h4 class="text-safety-orange mb-4">My Noodle Box Points: {{ points.toLocaleString() }}</h4>
        <h5 class="text-safety-orange">Ways to gain more points:</h5>
        <div class="my-account-block">
            <p>
                On social media, share the exclusive referral links we provide for you (updated every 7 days), and earn
                5
                points for every recommended purchase! It’s very easy to get started. Just paste the referral link below
                into your social media post. Be sure to briefly explain why you like our food or service. When your
                friends
                click the link and make a purchase, you will receive 30 points, which you can redeem for discounts on
                future
                purchases and enter our prize wheel/treasure chest. Thank you for helping us spread the word!
            </p>
            <p>You can check your points status in the (view points log).</p>
        </div>
        <h5 class="text-safety-orange">Referral Link</h5>
        <div class="my-account-block">
            <p class="text-safety-orange">{{referral_link_description}}</p>
            <div class="input-group">
                <input type="text" class="form-control referral-link" disabled :value="referralLink" readonly>
                <div class="input-group-append">
                    <button class="btn btn-bull-cyan text-white" v-clipboard:copy="referralLink"
                            v-clipboard:success="onCopy">Copy
                    </button>
                </div>
            </div>
        </div>
        <h5 class="text-safety-orange mt-5">Point Details</h5>
        <table class="list-table">
            <colgroup>
                <col width="*">
                <col width="120">
                <col width="120">
            </colgroup>
            <thead>
            <tr>
                <th>Details</th>
                <th>Points</th>
                <th>Time</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(item, index) in dataList" :key="index">
                <td class="text-safety-orange">{{ item.detail }}</td>
                <td>
                    <span class="text-success" v-if="item.type == 1">+{{ item.points }}</span>
                    <span class="text-danger" v-else>-{{ item.points }}</span>
                </td>
                <td>{{ $dayjs(item.created_at).format('YYYY-MM-DD') }}</td>
            </tr>
            </tbody>
        </table>
        <div class="pagination-container">
            <b-pagination
                    align="center"
                    v-model="currentPage"
                    :total-rows="rows"
                    :per-page="perPage"
                    @change="onPageChange"
            />
        </div>
    </div>
</template>

<script>
import HttpClient from "../HttpClient";

export default {
    name: "MyPoints",
    computed: {},
    data() {
        return {
            currentPage: 1,
            perPage: 10,
            rows: 0,
            points: 0,
            loading: true,
            error: null,
            dataList: [],
            referralLink: '',
            referral_points: 0,
            referral_link_description:''
        }
    },
    methods: {
        fetchPoints() {
            HttpClient.get('/my/points').then((res) => {
                this.points = res.data.points;
                this.referralLink = res.data.referralLink;
                this.referral_points = res.data.referral_points;
                this.referral_link_description = res.data.referral_link_description;
            }).catch(reason => {

            });
        },
        fetchList() {
            this.loading = true;
            let {currentPage, perPage} = this;
            HttpClient.get('/my/points/transactions', {
                params: {
                    offset: (currentPage - 1) * perPage,
                    limit: perPage
                }
            }).then((res) => {
                this.dataList = res.data.items;
                this.rows = res.data.total;
            }).catch(reason => {

            }).finally(() => {
                this.loading = false;
            });
        },
        onPageChange(page) {
            //console.log(page);
            this.currentPage = page;
            this.fetchList();
        },
        onCopy() {
            this.$showToast('Copied to clipboard');
        }
    },
    mounted() {
        this.fetchPoints();
        this.fetchList();
    },
}
</script>

<style scoped>

</style>