import { createRouter, createWebHistory } from 'vue-router';

import Home from './components/Home.vue';
import RecipeForm from './components/RecipeForm.vue';
import RecipeList from './components/RecipeList.vue';
import RecipeShow from './components/RecipeShow.vue';

const routes = [
    { path: '/', component: Home },
    { path: '/recipes', component: RecipeList },
    { path: '/recipes/create', component: RecipeForm },
    { path: '/recipes/:id', component: RecipeShow },
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
