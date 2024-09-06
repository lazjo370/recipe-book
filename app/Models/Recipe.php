<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\CuisineType;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'instruction', 'image', 'cuisine_type'];

    protected $casts = [
        'cuisine_type' => CuinsineType::class
    ];

    public function ingredients()
    {
        return $this->hasMany(Ingredient::class);
    }



}
