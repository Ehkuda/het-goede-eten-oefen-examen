<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gerecht;
use App\Models\Categorie;

class GerechtController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gerechten = Gerecht::with('categorie')->latest()->get();
        return view('gerechten.index', compact('gerechten'));
    }

    /**
     * Show the form for creating a new resource.
     */
public function create()
{
    $categorieen = Categorie::whereIn('naam', ['Voorgerecht', 'Hoofdgerecht'])->get();
    // of gewoon alle: $categorieen = Categorie::all();

    return view('gerechten.create', compact('categorieen'));
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'naam'                   => 'required|string|max:255',
            'categorie_id'           => 'required|exists:categorieen,id',
            'bereidingswijze'        => 'nullable|string',
            'bereidingstijd_minuten' => 'nullable|numeric|min:1|integer',
        ]);

        $gerecht = Gerecht::create($validated);

        if ($request->has('ingrediënten') && is_array($request->ingrediënten)) {
            foreach ($request->ingrediënten as $ingrediënt) {
                if (!empty($ingrediënt['naam']) && !empty($ingrediënt['hoeveelheid'])) {
                    $gerecht->ingrediënten()->create([
                        'naam'       => $ingrediënt['naam'],
                        'hoeveelheid' => $ingrediënt['hoeveelheid'],
                    ]);
                }
            }
        }

        return redirect()->route('gerechten.index')
            ->with('success', 'Recept succesvol toegevoegd!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Gerecht $gerecht)
    {
        $gerecht->load('categorie'); // optioneel: laad relatie
        return view('gerechten.show', compact('gerecht'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gerecht $gerecht)
    {
        $categorieen = Categorie::all();
        return view('gerechten.edit', compact('gerecht', 'categorieen'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gerecht $gerecht)
    {
        $validated = $request->validate([
            'naam'                   => 'required|string|max:255',
            'categorie_id'           => 'required|exists:categorieen,id',
            'bereidingswijze'        => 'nullable|string',
            'bereidingstijd_minuten' => 'nullable|numeric|min:1|integer',
        ]);

        $gerecht->update($validated);

        // Ingrediënten updaten zou hier ook moeten komen (verwijderen + opnieuw aanmaken of sync)

        return redirect()->route('gerechten.index')
            ->with('success', 'Recept succesvol bijgewerkt!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gerecht $gerecht)
    {
        $gerecht->delete();

        return redirect()->route('gerechten.index')
            ->with('success', 'Recept succesvol verwijderd!');
    }

    /**
     * Print / overzicht voor alle gerechten
     */
    public function print()
    {
        $gerechten = Gerecht::with('categorie')->get();
        return view('gerechten.print', compact('gerechten'));
    }

    public function menukaart()
{
    $gerechten = Gerecht::with('categorie')
        ->orderBy('categorie_id')
        ->orderBy('naam')
        ->get();

    return view('gerechten.menukaart', compact('gerechten'));
}
}