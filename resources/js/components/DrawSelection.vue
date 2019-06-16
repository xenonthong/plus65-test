<template>
    <div>
        <div class="input-group mb-3">
            <select class="custom-select text-capitalize" v-model="selectedPrizeType">
                <option value="-1" disabled>Select Option</option>
                <option v-for="prizeType in prizeTypes" :value="prizeType">{{ prizeType }}</option>
            </select>
        </div>

        <div class="input-group mb-3">
            <input type="text"
                   class="form-control"
                   v-model="winningNumber"
                   placeholder="123456">

            <div class="input-group-append">
                <button class="btn btn-outline-secondary"
                        type="button"
                        @click="generate">Generate Random Number
                </button>
            </div>
        </div>

        <button class="btn btn-primary" type="submit">Button</button>
    </div>
</template>

<script>
    import { find } from 'lodash';

    export default {
        props : ['prizeTypes'],

        data() {
            return {
                selectedPrizeType : -1,
                winningNumber : null
            }
        },

        methods : {
            generate() {
                if (!this.canGenerate()) return this.$toasted.error('Please provide a valid prize type');

                axios.get('/backend/winning-number', {
                    params : {
                        prize_type : this.selectedPrizeType
                    }
                })
                     .then((res) => {
                         this.winningNumber = res.data.value;

                         this.$toasted.success(`A number has been generated for ${this.selectedPrizeType}`);
                     })
            },

            /**
             * Checks if the option selected exist in our select options.
             *
             * @return {boolean}
             */
            canGenerate() {
                return typeof find(this.prizeTypes, (type) => type === this.selectedPrizeType) !== 'undefined';
            }
        },

        computed : {

        }
    }
</script>
