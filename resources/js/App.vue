<template>
    <div id='app' class="flex flex-col min-h-screen bg-gray-100">
        <header class="bg-green-500 shadow">
            <nav class="flex justify-center p-4">
                <router-link to="/">Home</router-link>
                <router-link to="/recipes">Recipes</router-link>
                <router-link to="/recipes/create">Add Recipe</router-link>
            </nav>
        </header>

        <main class="flex-1 max-w-4xl mx-auto p-6">
            <router-view />
        </main>
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
    name: 'App',
});
</script>

<style>
/* You can add global styles here */
</style>
