<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'instruction', 'image', 'cuisine_type'];

    public function ingredients()
    {
        return $this->hasMany(Ingredient::class);
    }

}
