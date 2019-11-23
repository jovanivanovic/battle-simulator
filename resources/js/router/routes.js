import Home from '../views/Home.vue'
import Game from '../views/Game.vue'
import AddArmy from "../views/AddArmy.vue";

export const routes = [
    {
        path: '/',
        name: 'Home',
        component: Home,
    },
    {
        path: '/game/:id',
        name: 'Game',
        component: Game,
    },
    {
        path: '/game/:id/add-army',
        name: 'AddArmy',
        component: AddArmy,
    },
];
