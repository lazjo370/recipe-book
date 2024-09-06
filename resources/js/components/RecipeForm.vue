<template>
    <div>
        <h1 class="text-2xl font-bold mb-4">Create Recipe</h1>

        <form @submit.prevent="submitForm">
            <input v-model="recipe.name" placeholder="Recipe Name" class="border p-2 mb-4 w-full" required/>
            <textarea v-model="recipe.instruction" placeholder="Instructions" class="border p-2 mb-4 w-full" required></textarea>
            <input v-model="recipe.cuisine_type" placeholder="Cuisine Type" class="border p-2 mb-4 w-full" required />
            <input type="file" @change="onFileChange" class="border p-2 mb-4 w-full"/>

            <h3 class="mt-4 mb-4"> Ingredients: </h3>
            <div v-for="(ingredient, index) in recipe.ingredients" :key="index" class="mb-4">
                <input v-model="ingredient.name" placeholder="Ingredient Name" required class="border p-2 w-1/3 mr-2"/>
                <input v-model="ingredient.quantity" placeholder="Quantity" required class="border p-2 w-1/3 mr-2" />

                <button @click.prevent="removeAddedIngredient(index)" class="bg-red-500 text-white px-2">Remove</button>
            </div>

            <button @click.prevent="addNewIngredient" class="bg-green-500 text-white px-4 py-2 mb-4 ">Add Ingredient</button>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 ml-4">Submit</button>
        </form>
    </div>
</template>

<script lang="ts">
import { Recipe } from '@/types/types';
import { defineComponent, ref } from 'vue';
import { useRecipeStore } from '@/stores/recipe';

export default defineComponent({
    name: 'RecipeForm',
    setup() {
        const initialRecipe = {
            name: '',
            instruction: '',
            cuisine_type: '',
            ingredients: [{name: '', quantity: ''}]
        };

        const recipe = ref<Recipe>(initialRecipe);

        const store = useRecipeStore();

        const resetForm = () => {
            recipe.value = initialRecipe;
        }
        const submitForm = async () => {
            // todo call store action
            try{
                await store.addRecipe(recipe.value);
            } catch(error) {
                console.error(error); // todo replace it later more handling
            }

            resetForm();
        }

        const onFileChange = (e: Event) => {
            // todo call handle image
            const target = e.target as HTMLInputElement;

            if(target.files) {
                recipe.value.image = target.files[0];
            }

        }

        const removeAddedIngredient = (index: number) => {
            recipe.value.ingredients.splice(index, 1);
        }

        const addNewIngredient = () => {
            recipe.value.ingredients.push({name: '', quantity: ''});
        }

        return { recipe, submitForm, onFileChange, removeAddedIngredient, addNewIngredient };
    }
});
</script>
