import Vue from 'vue'
import Router from 'vue-router'
import { routes } from './routes'
import store from "../store";

Vue.use(Router);

const router = new Router({
    mode: 'history',
    linkExactActiveClass: 'active',
    linkActiveClass: 'active',
    routes
});

Vue.router = router;

export default router
