<template>
    <div class="gzdsx-pos-autocomplete" v-click-outside="hide">
        <pos-input
                type="text"
                placeholder="Please Enter Product Name"
                @input="handleInput"
        >
            <i class="yith-pos-icon-search text-secondary" slot="append"></i>
        </pos-input>
        <div class="suggestions" v-if="suggestionVisible">
            <div class="suggestion-con" v-if="loading">
                <i class="gzdsx-pos-spinner"></i>
            </div>
            <div class="suggestion-con" v-if="suggestions===0&&!loading">No results found.</div>
            <div class="suggestion-item" v-for="(item,index) in suggestions" :key="index" @click="select(item)">
                <div class="suggestion-item__name">
                    <div>{{ item.name }}</div>
                    <span>add to cart</span>
                </div>
                <div class="suggestion-item__price">€{{ item.price }}</div>
                <div>
                    <img :src="$imageSrc(item.images[0].src)" class="suggestion-item__image" alt="">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
let controller = new AbortController();
export default {
    name: "AutoComplete",
    props: {},
    data() {
        return {
            suggestions: [],
            loading: false,
            suggestionVisible: false
        }
    },
    methods: {
        handleInput(search) {
            if (search.length < 2) {
                return;
            }

            if (controller) {
                controller.abort();
                controller = new AbortController();
            }

            this.loading = true;
            this.suggestions = [];
            this.suggestionVisible = true;
            this.$http.get('pos-products', {
                params: {keyword: search, per_page: 50},
                signal: controller.signal
            }).then(response => {
                //console.log(response);
                this.suggestionVisible = response.length > 0;
                this.suggestions = response;
            }).catch(() => {

            }).finally(() => {
                this.loading = false;
            });
        },
        select(item) {
            this.$emit('select', item);
        },
        hide() {
            this.suggestionVisible = false;
        }
    },
    mounted() {

    }
}
</script>

<style scoped>

</style>