<?php

namespace App\Http\Controllers;

use App\Http\Requests\FoodRequest;
use App\Models\Category;
use App\Models\Food;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $foods = Food::where('is_hidden', 0)->get();
        $hiddens = Food::where('is_hidden', 1)->get();
        $categories = Category::get();

        return view('food.index', compact('foods', 'hiddens', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $categories = Category::all();
        return view('food.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FoodRequest $request)
    {
        // ambil seluruh request
        $attr = $request->all();

        // Mengecek apakah file image ada apa tidak dan memasukkan kedalam storage
        $image = request()->file('image') ? request()->file('image')->store("images/menu") : null;

        // assign image ke attr
        $attr['image'] = $image;

        // Create new menu
        $post = Food::create($attr);

        session()->flash('success', 'The menu was created');

        return redirect('/menu');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Food  $food
     * @return \Illuminate\Http\Response
     */
    public function show(Food $food)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Food  $food
     * @return \Illuminate\Http\Response
     */
    public function edit(Food $food)
    {
        $categories = Category::all();
        return view('food.edit', compact('food', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Food  $food
     * @return \Illuminate\Http\Response
     */
    public function update(FoodRequest $request, Food $food)
    {

        // Ambil semua data
        $attr = $request->all();

        // Menghapus file image ketika update
        if (request()->file('image')) {
            \Storage::delete($food->image);
            $image = request()->file('image')->store("images/menu");
        } else {
            $image = $food->image;
        }

        $attr['image'] = $image;

        $food->update($attr);

        session()->flash('success', 'The menu was updated');

        return redirect('/menu');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Food  $food
     * @return \Illuminate\Http\Response
     */
    public function destroy(Food $food)
    {
        // Menghapus image dari storage
        \Storage::delete($food->image);

        // Menghapus row
        $food->delete();

        // Mengirim session
        session()->flash('success', 'The menu was destroyed');
        return redirect('/menu');
    }

    public function search()
    {
        $query = request('query');

        if ($query == null) {
            return redirect('/menu');
        }

        $foods = Food::where([
            ['is_hidden', 0],
            ['name', 'like', "%$query%"],
            ])->get();
        $hiddens = Food::where([
            ['is_hidden', 1],
            ['name', 'like', "%$query%"],
            ])->get();
        $categories = Category::get();

        return view('food.index', compact('foods', 'hiddens', 'categories'));
    }

    public function filter()
    {
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


        return view('food.createFilterBy', compact('foods', 'categoryTitle', 'categories'));
    }
}
