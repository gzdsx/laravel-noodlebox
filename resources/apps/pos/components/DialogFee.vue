<template>
    <pos-dialog title="Add Fee" :visible="value" @close="close">
        <div class="gzdsx-pos-dialog__content">
            <div class="form-group pos-row">
                <div class="pos-col-6">
                    <div class="form-label">Fee Name</div>
                    <div class="gzdsx-pos-autocomplete" v-click-outside="hide">
                        <pos-input type="text" @focus="focus" v-model="fee.name"/>
                        <div class="suggestions" v-if="suggestionVisible">
                            <div class="suggestion-item" v-for="(item,index) in suggestions" :key="index"
                                 @click="select(item)">
                                <div class="suggestion-item__name">
                                    {{ item.name }} x {{ item.quantity }}
                                </div>
                                <div class="suggestion-item__price">€{{ item.total }}</div>
                                <div class="suggestion-item__remove" @click.stop="remove(item)">
                                    <i class="yith-pos-icon-clear"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pos-col-2">
                    <div class="form-label">Quantity*</div>
                    <pos-input type="text" align="right" v-model="fee.quantity"/>
                </div>
                <div class="pos-col-2">
                    <div class="form-label">Amount*</div>
                    <pos-input type="text" align="right" v-model="fee.total"/>
                </div>
            </div>
            <number-pad
                    submit-label="update fee"
                    v-model="fee.total"
                    @back="close"
                    @submit="submit"
            />
        </div>
    </pos-dialog>
</template>

<script>
import NumberPad from "./NumberPad.vue";

export default {
    name: "DialogFee",
    components: {NumberPad},
    props: {
        value: Boolean,
    },
    data() {
        return {
            fee: {},
            suggestionVisible: false,
            suggestions: []
        }
    },
    methods: {
        close() {
            this.$emit('input', false);
        },
        hide() {
            this.suggestionVisible = false;
        },
        select(item) {
            this.fee.name = item.name;
            this.fee.total = item.total;
            this.fee.quantity = item.quantity;
            this.suggestionVisible = false;
        },
        focus() {
            if (this.suggestions.length > 0) {
                this.suggestionVisible = true;
            }
        },
        remove(item) {
            this.$http.delete('pos-shortcuts/' + item.id).then(resp => {
                this.fetchSuggestions();
            });
        },
        submit() {
            let exists = false;
            let {name, total, quantity} = this.fee;
            this.suggestions.map(o => {
                if (name.toLowerCase() === o.name.toLowerCase() && total == o.total && quantity == o.quantity) {
                    exists = true;
                }
            });

            if (!exists && name && total && quantity) {
                this.$http.post('pos-shortcuts', {name, total, quantity}).then(resp => {
                    this.fetchSuggestions();
                });
            }

            this.fee.name = name + ' x ' + quantity;
            this.$emit('submit', this.fee);
            this.$emit('input', false);
            this.resetFee();
        },
        fetchSuggestions() {
            this.$http.get('pos-shortcuts').then(resp => {
                this.suggestions = resp;
            });
        },
        resetFee() {
            this.fee = {
                name: '',
                total: '0',
                tax_status: 'none',
                total_tax: '0',
                quantity: 1
            }
        }
    },
    created() {
        this.resetFee();
        this.fetchSuggestions();
    }
}
</script>

<style scoped>

</style>