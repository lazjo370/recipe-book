import { defineStore } from "pinia";
import axios from 'axios';
import { Recipe } from "@/types/types";

export const useRecipeStore = defineStore('recipes', {
    state: () => ({
        recipes: [] as Recipe[],
    }),
    actions: {
        async addRecipe(recipe: Recipe) {
            console.log('recipe: ', recipe); // fixme
        }
    }
});
