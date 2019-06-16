<template>
    <div>
        <div class="input-group mb-3">
            <select class="custom-select text-capitalize" v-model="selectedPrizeType" @change="clearNumber">
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

        <button class="btn btn-primary" @click="submit">Save</button>
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
            /**
             * Generate a number based on the selected prize type.
             */
            generate() {
                if (!this.isValidPrizeType()) return this.$toasted.error('Please provide a valid prize type');

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
            isValidPrizeType() {
                return typeof find(this.prizeTypes, (type) => type === this.selectedPrizeType) !== 'undefined';
            },

            /**
             * Checks if user can save the draw result.
             */
            canSubmit() {
                return this.isValidPrizeType() && this.winningNumber;
            },

            /**
             * Save the draw result.
             */
            submit() {
                if (!this.canSubmit()) return this.$toasted.error('Please ensure that the select option and number is valid');

                axios.post('/backend/draws', {
                    params : {
                        type : this.selectedPrizeType,
                        number : this.winningNumber
                    }
                })
                     .then((res) => {
                         this.winningNumber = res.data.value;

                         this.reset();
                         this.$toasted.success(`The number has been added to the draw result.`);
                     })
            },

            /**
             * Reset all data.
             */
            reset() {
                this.selectedPrizeType = -1;
                this.winningNumber = null
            },

            /**
             * Clear winning number.
             */
            clearNumber() {
                this.winningNumber = null;
            }
        },

        computed : {}
    }
</script>
