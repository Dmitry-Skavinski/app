import { createRouter, createWebHistory } from "vue-router";

import Home from "./pages/Home.vue";
import Create from "./pages/Create.vue";

const routes = [
    {
        path : '/',
        component : Home
    },
    {
        path : '/create',
        component : Create
    }
]

export const router = createRouter({
    history: createWebHistory(),
    routes
});
