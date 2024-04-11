import ApiService from "../utils/ApiService";

export default {
    data() {
        return {
            settings: {}
        }
    },
    methods: {
        onSubmit() {
            let {settings} = this;
            ApiService.post('/settings', {settings}).then(() => {
                this.$message.success(this.$t('settings.saved'));
                if (this.updated) {
                    this.updated();
                }
            }).catch(reason => {
                this.$message.error(reason.message);
            });
        },
        boolVal(val) {
            return val === 1;
        }
    },
    created() {
        ApiService.get('/settings').then(res => {
            this.settings = res.data;
        });
    }
}