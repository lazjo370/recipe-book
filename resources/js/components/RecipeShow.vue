<template>
    <div v-if="recipe">
        <h1 class="text-2xl font-bold">{{ recipe.name }}</h1>
        <img v-if="recipe.image" :src="`/storage/${recipe.image}`" alt="Recipe Image" class="my-4" />
        <p><strong>Instruction:</strong> {{ recipe.instruction }}</p>
        <h2 class="mt-4">Ingredients:</h2>

        <table class="min-w-full border-collapse mt-4">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border-b p-4 text-left">Quantity</th>
                    <th class="border-b p-4 text-left">Ingredient</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="ingredient in recipe.ingredients" :key="ingredient.id">
                    <td class="border-b p-4">{{ ingredient.quantity }}</td>
                    <td class="border-b p-4">{{ ingredient.name }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div v-else>Loading...</div>
</template>

<script lang="ts">
import { defineComponent, ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import { useRecipeStore } from '../stores/recipe';
import { Recipe } from '@/types/types';

export default defineComponent({
    name: 'RecipeShow',
    setup() {
        const route = useRoute();
        const store = useRecipeStore();
        const recipe = ref<Recipe>({
            name: '',
            instruction: '',
            cuisine_type: '',
            ingredients: [{ id: 0, name: '', quantity: '' }],
        });

        onMounted(async () => {
            recipe.value = await store.getRecipe(Number(route.params.id));
        });

        return { recipe };
    },
});
</script>

<style scoped>
table {
    border: 1px solid #e2e8f0; /* Light gray border */
}

th {
    background-color: #edf2f7; /* Light gray */
}
</style>
