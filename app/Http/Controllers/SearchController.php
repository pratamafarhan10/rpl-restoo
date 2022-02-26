<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Food;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(){
        $query = request('query');

        if ($query == null) {
            return redirect('/pemesanan/create');
        }

        $foods = Food::where([
            ['is_hidden', 0],
            ['name', 'like', "%$query%"],
            ])->get();
        $categories = Category::get();

        return view('order.create', compact('foods', 'categories'));
    }
    
    public function filter(){
        $filter = request('category');

        $categoryTitle = '';

        if ($filter == 'hidden') {
            $foods = Food::where([
                ['is_hidden', 1],
            ])->get();
            $categoryTitle = 'Disembunyikan';
        } else {
            $foods = Food::where([
                ['category_id', $filter],
                ['is_hidden', 0],
            ])->get();
            $getTitle = $foods[0];
            $categoryTitle = $getTitle->category->category_name;
        }
        
        $categories = Category::get();

        return view('order.createFilterBy', compact('foods', 'categoryTitle', 'categories'));
    }
}