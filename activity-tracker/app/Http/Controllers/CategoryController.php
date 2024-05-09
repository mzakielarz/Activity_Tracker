<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index(){

        // Tworzymy prostą tablicę obiektów kategorii, domyślnie to się będzie brało z bazy, na teraz służy to tylko i wyłączne do zobrazowania zwracania danych do widoków z controlerów
        $categories = [
            (object) ['id' => 1, 'name' => 'Kategoria 1'],
            (object) ['id' => 2, 'name' => 'Kategoria 2'],
            (object) ['id' => 3, 'name' => 'Kategoria 3'],
        ];

        // Dzięki Interii zwracamy widok vue znajdujące się resources/js/Pages, jeżeli Category.vue znajdował by się np w resources/js/Pages/KolejneZagnieżdżenieFolderu, wtedy trzeba zwracać like this: return Inertia::render('KolejneZagnieżdżenieFolderu/Category'); compact('categories') dodaje do zwracanego widoku dane, alternatywą jest zapis ['categories'=>$categories], zadziała tak samo, ale trochę dłuższy zapis 
        return Inertia::render('Category', compact('categories'));
    }
}
