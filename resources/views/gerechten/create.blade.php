@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg">
            <div class="p-8">

                <h1 class="text-3xl font-bold text-gray-900 mb-8">
                    Nieuw recept toevoegen
                </h1>

                {{-- Fouten --}}
                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-400 text-red-700 p-4 rounded mb-6">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('gerechten.store') }}" method="POST" class="space-y-8">
                    @csrf

                    {{-- Basisgegevens --}}
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h2 class="text-xl font-semibold mb-4">Basisgegevens</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium mb-1">Naam *</label>
                                <input type="text"
                                       name="naam"
                                       value="{{ old('naam') }}"
                                       required
                                       class="w-full rounded-lg border-gray-300">
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-1">Categorie *</label>
                                <select name="categorie_id"
                                        required
                                        class="w-full rounded-lg border-gray-300">
                                    <option value="">Kies categorie</option>
                                    @foreach($categorieen as $cat)
                                        <option value="{{ $cat->id }}"
                                            {{ old('categorie_id') == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->naam }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- INGREDIËNTEN (NIEUW) --}}
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h2 class="text-xl font-semibold mb-4">Ingrediënten</h2>

                        <div id="ingredienten-container" class="space-y-4">
                            <!-- lege container, nieuwe rijen via JS -->
                        </div>

                        <button type="button"
                                id="add-ingredient"
                                class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded-lg">
                            + Ingrediënt toevoegen
                        </button>
                    </div>

                    {{-- Bereiding --}}
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h2 class="text-xl font-semibold mb-4">Bereiding</h2>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium mb-1">
                                    Bereidingstijd (minuten)
                                </label>
                                <input type="number"
                                       name="bereidingstijd_minuten"
                                       value="{{ old('bereidingstijd_minuten') }}"
                                       class="w-40 rounded-lg border-gray-300">
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-1">
                                    Bereidingswijze
                                </label>
                                <textarea name="bereidingswijze"
                                          rows="6"
                                          class="w-full rounded-lg border-gray-300">{{ old('bereidingswijze') }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Acties --}}
                    <div class="flex justify-end gap-4">
                        <a href="{{ route('gerechten.index') }}"
                           class="px-6 py-2 border rounded-lg">
                            Annuleren
                        </a>

                        <button type="submit"
                                class="px-6 py-2 bg-green-600 text-white rounded-lg">
                            Opslaan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

{{-- PRODUCT OPTIES VOOR INGREDIËNTEN --}}
@php
    $options = '';
    foreach ($producten as $p) {
        $options .= "<option value=\"{$p->id}\">{$p->naam}</option>";
    }
@endphp

{{-- JAVASCRIPT --}}
<script>
    const container = document.getElementById('ingredienten-container');
    const addBtn = document.getElementById('add-ingredient');
    const productOptions = `{!! $options !!}`;

    function addIngredientRow() {
        const index = container.children.length;

        const div = document.createElement('div');
        div.className = 'grid grid-cols-1 md:grid-cols-3 gap-4 p-4 bg-white border rounded-lg';

        div.innerHTML = `
            <div>
                <label class="block text-sm font-medium mb-1">Product</label>
                <select name="ingredienten[${index}][product_id]"
                        required
                        class="w-full rounded-lg border-gray-300">
                    <option value="">Kies product...</option>
                    ${productOptions}
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Hoeveelheid</label>
                <input type="text"
                       name="ingredienten[${index}][hoeveelheid]"
                       required
                       placeholder="bijv. 200 g"
                       class="w-full rounded-lg border-gray-300">
            </div>

            <div class="flex items-end">
                <button type="button"
                        class="remove px-4 py-2 bg-red-600 text-white rounded-lg">
                    Verwijder
                </button>
            </div>
        `;

        div.querySelector('.remove').onclick = () => div.remove();
        container.appendChild(div);
    }

    addBtn.onclick = addIngredientRow;

    // Start met 1 lege rij
    addIngredientRow();
</script>
@endsection
