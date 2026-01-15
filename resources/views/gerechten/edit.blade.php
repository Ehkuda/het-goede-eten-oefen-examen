@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8">
                    <h1 class="text-3xl font-bold text-gray-900 mb-8">Recept wijzigen: {{ $gerecht->naam }}</h1>

                    @if ($errors->any())
                        <div class="bg-red-50 border-l-4 border-red-400 text-red-700 p-4 rounded mb-6">
                            <p class="font-semibold mb-2">Er zijn enkele problemen met je invoer:</p>
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('gerechten.update', $gerecht) }}" method="POST" class="space-y-8">
                        @csrf
                        @method('PUT')

                        <!-- Basisgegevens -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">Basisgegevens</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="naam" class="block text-sm font-medium text-gray-700 mb-2">
                                        Naam recept <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="naam" id="naam" value="{{ old('naam', $gerecht->naam) }}" required
                                           class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('naam') border-red-300 @enderror">
                                    @error('naam')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="categorie_id" class="block text-sm font-medium text-gray-700 mb-2">
                                        Categorie <span class="text-red-500">*</span>
                                    </label>
                                    <select name="categorie_id" id="categorie_id" required
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('categorie_id') border-red-300 @enderror">
                                        <option value="">Kies een categorie</option>
                                        @foreach($categorieen as $cat)
                                            <option value="{{ $cat->id }}" {{ old('categorie_id', $gerecht->categorie_id) == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->naam }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('categorie_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Ingrediënten (bestaande tonen + dynamisch toevoegen/verwijderen) -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">Ingrediënten</h2>

                            <div id="ingredienten-container" class="space-y-4 mb-4">
                                @foreach($gerecht->ingrediënten as $index => $ingrediënt)
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-4 bg-white rounded-lg border border-gray-200 ingredient-row">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Naam ingrediënt</label>
                                            <input type="text" name="ingredienten[{{ $index }}][naam]" value="{{ old("ingredienten.$index.naam", $ingrediënt->naam) }}" required
                                                   class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Hoeveelheid</label>
                                            <input type="text" name="ingredienten[{{ $index }}][hoeveelheid]" value="{{ old("ingredienten.$index.hoeveelheid", $ingrediënt->hoeveelheid) }}" required
                                                   class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <input type="hidden" name="ingredienten[{{ $index }}][id]" value="{{ $ingrediënt->id }}">
                                        </div>
                                        <div class="flex items-end">
                                            <button type="button" class="remove-ingredient px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm font-medium">
                                                Verwijder
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <button type="button" id="add-ingredient"
                                    class="inline-flex items-center px-5 py-2.5 border border-transparent text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Ingrediënt toevoegen
                            </button>
                        </div>

                        <!-- Bereiding -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">Bereiding</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="bereidingstijd_minuten" class="block text-sm font-medium text-gray-700 mb-2">
                                        Bereidingstijd (minuten)
                                    </label>
                                    <input type="number" name="bereidingstijd_minuten" id="bereidingstijd_minuten"
                                           min="1" value="{{ old('bereidingstijd_minuten', $gerecht->bereidingstijd_minuten) }}"
                                           class="block w-full md:w-3/4 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>

                                <div class="md:col-span-2">
                                    <label for="bereidingswijze" class="block text-sm font-medium text-gray-700 mb-2">
                                        Bereidingswijze
                                    </label>
                                    <textarea name="bereidingswijze" id="bereidingswijze" rows="8"
                                              class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                              placeholder="Beschrijf de bereidingswijze stap voor stap...">{{ old('bereidingswijze', $gerecht->bereidingswijze) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Actieknoppen -->
                        <div class="flex justify-end items-center space-x-4 pt-4 border-t">
                            <a href="{{ route('gerechten.index') }}"
                               class="px-6 py-3 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                                Annuleren
                            </a>
                            <button type="submit"
                                    class="px-8 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium shadow-sm">
                                Wijzigingen opslaan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript voor dynamische ingrediënten (ook in edit) -->
    <script>
        document.getElementById('add-ingredient').addEventListener('click', function() {
            const container = document.getElementById('ingredienten-container');
            const index = container.children.length;

            const row = document.createElement('div');
            row.className = 'grid grid-cols-1 md:grid-cols-3 gap-4 p-4 bg-white rounded-lg border border-gray-200 ingredient-row';

            row.innerHTML = `
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Naam ingrediënt</label>
                    <input type="text" name="ingredienten[${index}][naam]" required
                           placeholder="bijv. Tomaten"
                           class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hoeveelheid</label>
                    <input type="text" name="ingredienten[${index}][hoeveelheid]" required
                           placeholder="bijv. 200 g / 2 stuks"
                           class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div class="flex items-end">
                    <button type="button" class="remove-ingredient px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm font-medium">
                        Verwijder
                    </button>
                </div>
            `;

            container.appendChild(row);

            row.querySelector('.remove-ingredient').addEventListener('click', () => row.remove());
        });
    </script>
@endsection