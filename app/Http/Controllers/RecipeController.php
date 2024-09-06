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
            'cuisine_type' => 'required|in:'.implode(',', array_column(CuisineType::class(), 'value')), // todo check if it works later
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
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
