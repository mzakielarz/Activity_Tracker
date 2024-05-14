<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(){

        $categories = [
            (object) ['id' => 1, 'name' => 'Kategoria 1'],
            (object) ['id' => 2, 'name' => 'Kategoria 2'],
            (object) ['id' => 3, 'name' => 'Kategoria 3'],
        ];

        return Inertia::render('Category', compact('categories'));
    }

    public function store(Request $request){
        $validated = $request->validate([
            'name' => 'required|unique:categories|max:255',
        ]);
        $newCategory = new Category;
        $newCategory->name = $request->name;
        $newCategory->user_id = auth()->id();
        $newCategory->save();
        $categories = Category::all();
        return Inertia::render('Category', compact('categories'));
    }
}
