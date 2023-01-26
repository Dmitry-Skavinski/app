import { createRouter, createWebHistory } from "vue-router";

import Home from "./pages/Home.vue";
import Create from "./pages/Create.vue";
import Nonogram from "./pages/Nonogram.vue";

const routes = [
    {
        path : '/',
        component : Home
    },
    {
        path : '/create',
        component : Create
    },
    {
        path : '/nonogram/:id',
        component : Nonogram
    }
]

export const router = createRouter({
    history: createWebHistory(),
    routes
});
