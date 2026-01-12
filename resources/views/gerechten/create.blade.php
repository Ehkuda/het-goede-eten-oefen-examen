@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-6">Nieuw recept toevoegen</h1>

                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('gerechten.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="naam" class="block text-sm font-medium text-gray-700">Naam recept *</label>
                                <input type="text" name="naam" id="naam" value="{{ old('naam') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('naam') border-red-300 @enderror">
                                @error('naam')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="categorie_id" class="block text-sm font-medium text-gray-700">Categorie *</label>
                                <select name="categorie_id" id="categorie_id"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('categorie_id') border-red-300 @enderror">
                                    <option value="">Kies een categorie</option>
                                    @foreach($categorieen as $cat)
                                        <option value="{{ $cat->id }}" {{ old('categorie_id') == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->naam }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('categorie_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6">
                            <label for="bereidingstijd_minuten" class="block text-sm font-medium text-gray-700">Bereidingstijd (minuten)</label>
                            <input type="number" name="bereidingstijd_minuten" id="bereidingstijd_minuten" min="1" value="{{ old('bereidingstijd_minuten') }}"
                                   class="mt-1 block w-full md:w-1/3 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <div class="mt-6">
                            <label for="bereidingswijze" class="block text-sm font-medium text-gray-700">Bereidingswijze</label>
                            <textarea name="bereidingswijze" id="bereidingswijze" rows="6"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('bereidingswijze') }}</textarea>
                        </div>

                        <!-- Ingrediënten komen later – begin eerst met basis CRUD -->

                        <div class="mt-8 flex justify-end space-x-4">
                            <a href="{{ route('gerechten.index') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">
                                Annuleren
                            </a>
                            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                                Recept opslaan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection