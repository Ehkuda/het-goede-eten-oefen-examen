<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GerechtController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $gerechten = Gerecht::with('categorie')->get();
    return view('gerechten.index', compact('gerechten'));
}

public function create()
{
    $categorieen = Categorie::all();
    return view('gerechten.create', compact('categorieen'));
}

public function store(Request $request)
{
    $validated = $request->validate([
        'naam'              => 'required|string|max:255',
        'categorie_id'      => 'required|exists:categorieen,id',
        'bereidingswijze'   => 'nullable|string',
        'bereidingstijd_minuten' => 'nullable|numeric|min:1',
        'ingrediënten.*.naam'       => 'required|string',
        'ingrediënten.*.hoeveelheid'=> 'required|string',
    ]);

    $gerecht = Gerecht::create($validated);

    foreach ($request->ingrediënten ?? [] as $ing) {
        if (!empty($ing['naam'])) {
            $gerecht->ingrediënten()->create($ing);
        }
    }

    return redirect()->route('gerechten.index')->with('success', 'Recept toegevoegd.');
}


}
