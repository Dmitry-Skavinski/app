import { createRouter, createWebHistory } from "vue-router";

import Home from "./pages/Home.vue";
import Create from "./pages/Create.vue";
import Nonogram from "./pages/Nonogram.vue";
import Author from "./pages/Author.vue";

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
    },
    {
        path : '/author/:id',
        component : Author
    }
]

export const router = createRouter({
    history: createWebHistory(),
    routes
});
