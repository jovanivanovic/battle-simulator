import Vue from 'vue';
import App from './App.vue';

import router from './router';
import store from './store';

import Toasted from 'vue-toasted';

Vue.use(Toasted);

const app = new Vue({
    el: '#app',
    components: { App },
    template: '<App/>',
    router,
    store
});
