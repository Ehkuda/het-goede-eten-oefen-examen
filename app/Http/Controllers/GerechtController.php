<?php

namespace App\Http\Controllers;

use App\Models\Gerecht;
use App\Models\Categorie;
use Illuminate\Http\Request;

class GerechtController extends Controller
{
    /**
     * Overzicht van alle gerechten
     */
    public function index()
    {
        $gerechten = Gerecht::with('categorie')
            ->latest()
            ->get();

        return view('gerechten.index', compact('gerechten'));
    }

    /**
     * Formulier om een gerecht aan te maken
     */
    public function create()
    {
        $categorieen = Categorie::whereIn('naam', [
            'Voorgerecht',
            'Hoofdgerecht',
        ])->get();

        return view('gerechten.create', compact('categorieen'));
    }

    /**
     * Opslaan van een nieuw gerecht
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'naam'                   => 'required|string|max:255',
            'categorie_id'           => 'required|exists:categorieen,id',
            'bereidingswijze'        => 'nullable|string',
            'bereidingstijd_minuten' => 'nullable|integer|min:1',
        ]);

        $gerecht = Gerecht::create($validated);

        if (is_array($request->ingrediënten ?? null)) {
            foreach ($request->ingrediënten as $ingrediënt) {
                if (
                    !empty($ingrediënt['naam']) &&
                    !empty($ingrediënt['hoeveelheid'])
                ) {
                    $gerecht->ingrediënten()->create([
                        'naam'        => $ingrediënt['naam'],
                        'hoeveelheid' => $ingrediënt['hoeveelheid'],
                    ]);
                }
            }
        }

        return redirect()
            ->route('gerechten.index')
            ->with('success', 'Recept succesvol toegevoegd!');
    }

    /**
     * Detailpagina van één gerecht
     */
    public function show(Gerecht $gerecht)
    {
        $gerecht->load('categorie');

        return view('gerechten.show', compact('gerecht'));
    }

    /**
     * Formulier om een gerecht te bewerken
     */
    public function edit(Gerecht $gerecht)
    {
        $categorieen = Categorie::all();

        return view('gerechten.edit', compact('gerecht', 'categorieen'));
    }

    /**
     * Bijwerken van een gerecht
     */
    public function update(Request $request, Gerecht $gerecht)
    {
        $validated = $request->validate([
            'naam'                   => 'required|string|max:255',
            'categorie_id'           => 'required|exists:categorieen,id',
            'bereidingswijze'        => 'nullable|string',
            'bereidingstijd_minuten' => 'nullable|integer|min:1',
        ]);

        $gerecht->update($validated);

        // Ingrediënten: eventueel later syncen/vernieuwen

        return redirect()
            ->route('gerechten.index')
            ->with('success', 'Recept succesvol bijgewerkt!');
    }

    /**
     * Verwijderen van een gerecht
     */
    public function destroy(Gerecht $gerecht)
    {
        \Log::info(
            "DESTROY aangeroepen voor gerecht {$gerecht->id} ({$gerecht->naam})"
        );

        try {
            $gerecht->delete();

            \Log::info(
                "Gerecht {$gerecht->id} succesvol verwijderd"
            );
        } catch (\Exception $e) {
            \Log::error(
                "Fout bij verwijderen gerecht {$gerecht->id}: {$e->getMessage()}"
            );

            throw $e;
        }

        return redirect()
            ->route('gerechten.index')
            ->with('success', 'Recept succesvol verwijderd!');
    }

    /**
     * Printoverzicht
     */
    public function print()
    {
        $gerechten = Gerecht::with('categorie')->get();

        return view('gerechten.print', compact('gerechten'));
    }

    /**
     * Menukaart overzicht
     */
    public function menukaart()
    {
        $gerechten = Gerecht::with('categorie')
            ->orderBy('categorie_id')
            ->orderBy('naam')
            ->get();

        return view('gerechten.menukaart', compact('gerechten'));
    }
}
