import ApiService from "../utils/ApiService";

export default {
    data() {
        return {
            page: 1,
            total: 0,
            pageSize: 15,
            dataList: [],
            selectionIds: [],
            loading: false,
        }
    },
    methods: {
        fetchList() {
            let {page, pageSize} = this;
            let offset = (page - 1) * pageSize;
            this.loading = true;
            ApiService.get(this.listApi(), {
                params: {
                    ...this.listParams(),
                    offset,
                    limit: pageSize
                }
            }).then(response => {
                let {total, items} = response.data;
                this.total = total;
                this.dataList = items;
                this.onFinish(response);
            }).catch(reason => {
                this.$message.error(reason.message);
            }).finally(() => {
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

        },
        listApi() {
            return '/';
        },
        listParams() {
            return {}
        }
    }
}
