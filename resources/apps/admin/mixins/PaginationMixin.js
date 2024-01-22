import ApiService from "../utils/ApiService";

export default {
    data() {
        return {
            page: 1,
            total: 0,
            pageSize: 15,
            dataList: [],
            params: {},
            listApi: '',
            selectionIds: [],
            loading: false,
        }
    },
    methods: {
        fetchList() {
            if (this.loading) {
                return;
            } else {
                this.loading = true;
            }

            let {page, pageSize, params, listApi} = this;
            let offset = (page - 1) * pageSize;
            let limit = pageSize;
            ApiService.get(listApi, {
                params: {
                    ...params,
                    offset,
                    limit
                }
            }).then(response => {
                let {total, items} = response.result;
                this.total = total;
                this.dataList = items;
                this.onFinish(response);
            }).catch(reason => {
                this.$message.error(reason.message);
            }).then(() => {
                this.loading = false;
            });
        },
        onSelectionChange(val) {
            this.selectionIds = val;
        },
        onPageChange(page) {
            this.page = page;
            this.fetchList();
        },
        onSearch() {
            this.page = 1;
            this.fetchList();
        },
        onFinish() {

        }
    }
}
