<?php

namespace App\Http\Controllers;

use App\Models\Gerecht;
use App\Models\Categorie;
use App\Models\Product;
use Illuminate\Http\Request;
use Spatie\LaravelPdf\Facades\Pdf;

class GerechtController extends Controller
{
    public function index()
    {
        $gerechten = Gerecht::with('categorie')->latest()->get();
        return view('gerechten.index', compact('gerechten'));
    }

    public function create()
    {
        $categorieen = Categorie::whereIn('naam', ['Voorgerecht', 'Hoofdgerecht'])->get();
        $producten = Product::orderBy('naam')->get();

        return view('gerechten.create', compact('categorieen', 'producten'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'naam'                   => 'required|string|max:255',
            'categorie_id'           => 'required|exists:categorieen,id',
            'bereidingswijze'        => 'nullable|string',
            'bereidingstijd_minuten' => 'nullable|integer|min:1',

            'ingredienten'                  => 'required|array|min:1',
            'ingredienten.*.product_id'     => 'required|exists:producten,id',
            'ingredienten.*.hoeveelheid'    => 'required|string|max:100',
        ]);

        // Alleen gerecht-velden
        $gerecht = Gerecht::create([
            'naam' => $validated['naam'],
            'categorie_id' => $validated['categorie_id'],
            'bereidingswijze' => $validated['bereidingswijze'] ?? null,
            'bereidingstijd_minuten' => $validated['bereidingstijd_minuten'] ?? null,
        ]);

        foreach ($validated['ingredienten'] as $ing) {
            $gerecht->ingredienten()->create([
                'product_id'  => $ing['product_id'],
                'hoeveelheid' => $ing['hoeveelheid'],
            ]);
        }

        return redirect()
            ->route('gerechten.index')
            ->with('success', 'Recept succesvol toegevoegd!');
    }

    public function show(Gerecht $gerecht)
    {
        $gerecht->load(['categorie', 'ingredienten.product']);
        return view('gerechten.show', compact('gerecht'));
    }

    public function edit(Gerecht $gerecht)
    {
        $gerecht->load('ingredienten.product');
        $categorieen = Categorie::whereIn('naam', ['Voorgerecht', 'Hoofdgerecht'])->get();
        $producten = Product::orderBy('naam')->get();

        return view('gerechten.edit', compact('gerecht', 'categorieen', 'producten'));
    }

    public function update(Request $request, Gerecht $gerecht)
    {
        $validated = $request->validate([
            'naam'                   => 'required|string|max:255',
            'categorie_id'           => 'required|exists:categorieen,id',
            'bereidingswijze'        => 'nullable|string',
            'bereidingstijd_minuten' => 'nullable|integer|min:1',

            'ingredienten'                  => 'required|array|min:1',
            'ingredienten.*.product_id'     => 'required|exists:producten,id',
            'ingredienten.*.hoeveelheid'    => 'required|string|max:100',
        ]);

        $gerecht->update([
            'naam' => $validated['naam'],
            'categorie_id' => $validated['categorie_id'],
            'bereidingswijze' => $validated['bereidingswijze'] ?? null,
            'bereidingstijd_minuten' => $validated['bereidingstijd_minuten'] ?? null,
        ]);

        // Oude ingrediënten verwijderen
        $gerecht->ingredienten()->delete();

        // Nieuwe toevoegen
        foreach ($validated['ingredienten'] as $ing) {
            $gerecht->ingredienten()->create([
                'product_id'  => $ing['product_id'],
                'hoeveelheid' => $ing['hoeveelheid'],
            ]);
        }

        return redirect()
            ->route('gerechten.index')
            ->with('success', 'Recept succesvol bijgewerkt!');
    }

    public function destroy(Gerecht $gerecht)
    {
        $gerecht->delete();

        return redirect()
            ->route('gerechten.index')
            ->with('success', 'Recept succesvol verwijderd!');
    }

    public function print()
    {
    $gerechten = Gerecht::with('categorie')
        ->orderBy('categorie_id')
        ->orderBy('naam')
        ->get();

    return Pdf::view('gerechten.menukaart-print', compact('gerechten'))
        ->format('a4')
        ->landscape(false)          
        ->margins(20, 15, 20, 15)   
        ->name('menukaart-het-goede-eten.pdf')
        ->download();               
        
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
