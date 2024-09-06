<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Enums\CuisineType;


class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Recipe::with('ingredients')->orderBy('created_at', 'desc')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'instruction' => 'required|string',
            'image' => 'nullable|image|mimes:png,jpg|max:2048',
            'cuisine_type' => 'nullable|string|max:255',
            'ingredients' => 'required|array',
            'ingredients.*.name' => 'required|string|max:255',
            'ingredients.*.quantity' => 'required|string|max:255',
        ]);

        $recipe = new Recipe();

        $recipe = Recipe::create($request->only('name', 'instruction'));

        if($request->cuisin_type) $recipe->cuisine_type = CuisineType::from($request->cuisin_type);
        if($request->hasFile('image')){
            $path = $request->file('image')->store('images', 'public');
            $recipe->image = $path;
            $recipe->save();
        }

        foreach($request->ingredients as $ingredient) {
            $recipe->ingredients()->create($ingredient);
        }

        return response()->json($recipe->load('ingredients'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Recipe $recipe)
    {
        return $recipe->load('ingredients');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Recipe $recipe)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'instructions' => 'required|string',
            'cuisine_type' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ingredients' => 'required|array',
        ]);

        $recipe->update($request->only('name', 'instructions'));

        if($request->cuisin_type) $recipe->cuisine_type = CuisineType::from($request->cuisin_type);

        if ($request->hasFile('image')) {
            if ($recipe->image) {
                Storage::delete('public/' . $recipe->image);
            }
            $path = $request->file('image')->store('images', 'public');
            $recipe->image = $path;
            $recipe->save();
        }

        $recipe->ingredients()->delete();
        foreach ($request->ingredients as $ingredient) {
            $recipe->ingredients()->create($ingredient);
        }

        return response()->json($recipe->load('ingredients'), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recipe $recipe)
    {
        if ($recipe->image) {
            Storage::delete('public/' . $recipe->image);
        }
        $recipe->delete();
        return response()->json(null, 204);
    }
}
