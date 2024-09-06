export interface Ingredient {
    id?: number;
    name: string;
    quantity: string;
};


export interface Recipe {
    id?: number;
    name: string;
    instructions: string;
    cuisine_type: string;
    image?: File | null;
    ingredients: Ingredient[];
};
