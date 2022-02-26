<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    public $table = 'foods';

    protected $fillable = ['name', 'description', 'ingredients', 'category_id', 'price', 'image', 'is_hidden'];

    public function takeImage(){
        return "/storage/" . $this->image;
    }
    
    public function category(){
        return $this->belongsTo(Category::class);
    }
}
