import { defineStore } from 'pinia';
import axios from 'axios';
import { Recipe  } from '@/types/types';

export const useRecipeStore = defineStore('recipes', {
    state: () => ({
        recipes: [] as Recipe[],
    }),
    actions: {
        async addRecipe(recipe: Recipe) {
            const formData = new FormData();
            formData.append('name', recipe.name);
            formData.append('instruction', recipe.instruction);
            formData.append('cuisine_type', recipe.cuisine_type || '');
            if (recipe.image) {
                formData.append('image', recipe.image);
            }

            recipe.ingredients.forEach((ingredient, index) => {
                formData.append(`ingredients[${index}][name]`, ingredient.name);
                formData.append(`ingredients[${index}][quantity]`, ingredient.quantity);
            });

            await axios.post('/api/recipes', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            });
        },
    },
});
