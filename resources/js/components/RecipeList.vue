<template>
    <div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-md">
        <h1 class="text-3xl font-bold mb-6 text-center">Recipe List</h1>
        <input
            v-model="search"
            placeholder="Search recipes..."
            class="border border-gray-300 p-3 mb-6 w-full rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
        <table class="min-w-full border-collapse">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border-b p-4 text-left">Image</th>
                    <th class="border-b p-4 text-left">Name</th>
                    <th class="border-b p-4 text-left">Instruction</th>
                    <th class="border-b p-4 text-left">Cuisine Type</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                <tr v-for="recipe in filteredRecipes" :key="recipe.id">
                    <td class="border-b p-4">
                        <img :src="`/storage/${recipe.image}`" alt="Recipe Image" class="w-24 h-24 object-cover rounded-lg" />
                    </td>
                    <td class="border-b p-4">
                        <router-link :to="`/recipes/${recipe.id}`" class="text-blue-600 hover:underline">
                            {{ recipe.name }}
                        </router-link>
                    </td>
                    <td class="border-b p-4">{{ recipe.instruction }}</td>
                    <td class="border-b p-4">{{ recipe.cuisine_type }}</td>
                </tr>
            </tbody>
        </table>
        <div v-if="filteredRecipes.length === 0" class="mt-4 text-gray-500 text-center">
            No recipes found.
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent, ref, computed, onMounted } from 'vue';
import { useRecipeStore } from '../stores/recipe';
import { Recipe } from '@/types/types';

export default defineComponent({
    name: 'RecipeList',
    setup() {
        const store = useRecipeStore();
        const search = ref('');
        const recipes = ref<Recipe[]>([]);

        onMounted(async () => {
            recipes.value = await store.fetchRecipes();
        });

        const filteredRecipes = computed(() => {
            return recipes.value.filter(recipe =>
                recipe.name.toLowerCase().includes(search.value.toLowerCase())
            );
        });

        return { search, filteredRecipes };
    },
});
</script>

<style scoped>
/* Optional additional styles */
table {
    border: 1px solid #e2e8f0; /* Light gray border */
}

th {
    background-color: #edf2f7; /* Light gray */
}
</style>
