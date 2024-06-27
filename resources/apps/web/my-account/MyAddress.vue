<template>
    <div>
        <h4 class="text-safety-orange">Shipping Address</h4>
        <div class="my-account-block">
            <div class="form-group">
                <div class="form-input-label">Name</div>
                <div>
                    <b-form-input v-model="shipping.first_name" placeholder="Name"/>
                </div>
            </div>
            <div class="form-group">
                <div class="form-input-label">Phone</div>
                <div>
                    <b-form-input v-model="shipping.first_name" placeholder="Name"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import HttpClient from "../HttpClient";

export default {
    name: "MyAddress",
    data() {
        return {
            loading: false,
            dataList: [],
            rows: 0,
            perPage: 15,
            error: null,
            currentPage: 1,
            name: 'MyAddress',
            shipping: {},
            billing: {}
        }
    },
    methods: {
        fetchList() {
            this.loading = true;
            let {currentPage, perPage} = this;
            HttpClient.get('/my/addresses', {
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
    },
    mounted() {
        this.fetchList();
    }
}
</script>

<style scoped>

</style>