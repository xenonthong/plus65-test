<template>
    <div>
        <div class="input-group mb-3">
            <select class="custom-select">
                <option selected>Open this select menu</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
            </select>
        </div>

        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon1">

            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="button">Generate Random Number</button>
            </div>
        </div>

        <button class="btn btn-primary" type="submit">Button</button>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
