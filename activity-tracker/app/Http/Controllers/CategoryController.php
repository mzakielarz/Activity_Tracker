<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(){

        // pobieranie danych z bazy
        $categories = Category::with('activities')->withCount('activities')->withAvg('activities', 'spent_time')->get();

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

        // Próba zapisu do bazy danych
        if ($newCategory->save()) {
            // Przekierowanie do listy kategorii po pomyślnym zapisaniu - dzięki temu unikamy zduplikowanej logiki z ponownym pobieraniem kategorii, zamiast tego odwołujemy się do funkcji która już to robi
            return redirect()->route('category.index');
        }
    }

    public function show(Category $category){
        $category->load('activities');
        return Inertia::render('Activity', compact('category'));
    }

    public function destroy($id)
    {
        $category = Category::find($id);

        if ($category) {
            $category->delete();
            return redirect()->back()->with('message', 'Kategoria została usunięta!');
        } else {
            return redirect()->back()->with('error', 'Nie znaleziono kategorii!');
        }
    }

    //krósza wersja usuwania kategorii - nie przekazujemy id kategorii, tylko cały obiekt kategorii(tak, tak można), dlatego nie musimy pisać dodatkowej logiki żeby sprawdzić czy kategoria z danym id istnieje, czy można ją pobrać z bazy itp
    // public function destroy2(Category $category)
    // {
    //     $category->delete();
    // }
}
