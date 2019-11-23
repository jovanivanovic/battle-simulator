<template>
    <div id="app">
        <h1 class="site-title">Battle Simulator</h1>
        <router-view />
    </div>
</template>

<style>
    .site-title {
        text-align: center;
    }
</style>

<script>
    export default {
        name: 'App',
        data() {
            return {

            }
        },
        computed: {
            userLoggedIn() {
                return this.$store.getters.isLoggedIn;
            },
        }
    }
</script>
