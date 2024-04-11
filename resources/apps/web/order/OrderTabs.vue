<template>
    <div class="my-order-tabs">
        <div
                class="tab-item"
                v-for="(tab,k) in tabs"
                :class="{'tab-item__active':k===activeTab}"
                :key="k"
                @click="onClickTab(k)"
        >{{ tab }}
        </div>
    </div>
</template>

<script>
export default {
    name: "OrderTabs",
    props: {
        activeTab: {
            type: String,
            default: 'all'
        }
    },
    data() {
        return {
            tabs: {
                'all': 'All',
                'pending': 'Pending',
                'processing': 'Processing',
                'shipping': 'Shipping',
                'completed': 'Completed',
            },
        }
    },
    methods: {
        onClickTab(tab) {
            this.activeTab = tab;
            this.$emit('change', tab);
        }
    }
}
</script>

<style scoped>

</style>