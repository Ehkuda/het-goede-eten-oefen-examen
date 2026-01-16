@extends('layouts.app')

@section('content')
<div class="py-12 bg-red-50/30 min-h-screen">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-2xl rounded-3xl overflow-hidden border border-red-100">
            
            <div class="bg-red-600 p-8 text-white">
                <h1 class="text-3xl font-black italic tracking-tighter uppercase">
                    Nieuw <span class="text-red-200">Recept</span> Toevoegen
                </h1>
                <p class="text-red-100 mt-2 font-medium">Vul de details in om een nieuw gerecht aan de menukaart toe te voegen.</p>
            </div>

            <div class="p-8">
                {{-- Fouten Meldingen --}}
                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r-xl mb-8 shadow-sm">
                        <div class="flex items-center mb-2">
                            <span class="font-black uppercase text-sm tracking-widest">Oeps! Er ging iets mis:</span>
                        </div>
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('gerechten.store') }}" method="POST" class="space-y-10">
                    @csrf

                    {{-- Sectie 1: Basisgegevens --}}
                    <section>
                        <h2 class="text-xl font-black text-gray-900 mb-6 flex items-center italic">
                            <span class="bg-red-600 text-white w-8 h-8 rounded-lg flex items-center justify-center mr-3 not-italic shadow-md">1</span>
                            Basisgegevens
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 bg-gray-50 p-6 rounded-2xl border border-gray-100">
                            <div>
                                <label class="block text-xs font-black text-red-600 uppercase tracking-widest mb-2">Naam Gerecht *</label>
                                <input type="text" name="naam" value="{{ old('naam') }}" required
                                       class="w-full rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500 p-3 shadow-sm transition"
                                       placeholder="bijv. Spaghetti Carbonara">
                            </div>

                            <div>
                                <label class="block text-xs font-black text-red-600 uppercase tracking-widest mb-2">Categorie *</label>
                                <select name="categorie_id" required
                                        class="w-full rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500 p-3 shadow-sm transition">
                                    <option value="">Kies een categorie...</option>
                                    @foreach($categorieen as $cat)
                                        <option value="{{ $cat->id }}" {{ old('categorie_id') == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->naam }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </section>

                    {{-- Sectie 2: Ingrediënten --}}
                    <section>
                        <h2 class="text-xl font-black text-gray-900 mb-6 flex items-center italic">
                            <span class="bg-red-600 text-white w-8 h-8 rounded-lg flex items-center justify-center mr-3 not-italic shadow-md">2</span>
                            Ingrediënten
                        </h2>
                        <div id="ingredienten-container" class="space-y-4">
                            </div>

                        <button type="button" id="add-ingredient"
                                class="mt-6 flex items-center px-6 py-3 bg-white border-2 border-red-600 text-red-600 rounded-xl font-black uppercase text-xs tracking-widest hover:bg-red-50 transition shadow-sm">
                            <span class="text-lg mr-2">+</span> Voeg Ingrediënt Toe
                        </button>
                    </section>

                    {{-- Sectie 3: Bereidingswijze --}}
                    <section>
                        <h2 class="text-xl font-black text-gray-900 mb-6 flex items-center italic">
                            <span class="bg-red-600 text-white w-8 h-8 rounded-lg flex items-center justify-center mr-3 not-italic shadow-md">3</span>
                            Bereidingswijze
                        </h2>
                        <div class="space-y-6 bg-gray-50 p-6 rounded-2xl border border-gray-100">
                            <div class="w-48">
                                <label class="block text-xs font-black text-red-600 uppercase tracking-widest mb-2">Tijd (minuten)</label>
                                <div class="relative">
                                    <input type="number" name="bereidingstijd_minuten" value="{{ old('bereidingstijd_minuten') }}"
                                           class="w-full rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500 p-3 pl-10 shadow-sm transition">
                                    <span class="absolute left-3 top-3 opacity-40">⏱️</span>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-black text-red-600 uppercase tracking-widest mb-2">Stapsgewijze instructies</label>
                                <textarea name="bereidingswijze" rows="6"
                                          class="w-full rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500 p-4 shadow-sm transition"
                                          placeholder="Hoe maken we dit heerlijke gerecht?">{{ old('bereidingswijze') }}</textarea>
                            </div>
                        </div>
                    </section>

                    {{-- Acties --}}
                    <div class="flex items-center justify-end gap-6 pt-6 border-t border-gray-100">
                        <a href="{{ route('gerechten.index') }}"
                           class="text-gray-400 hover:text-red-600 font-bold uppercase text-xs tracking-widest transition">
                            Annuleren
                        </a>

                        <button type="submit"
                                class="px-10 py-4 bg-red-600 text-white rounded-2xl font-black uppercase tracking-widest hover:bg-red-700 shadow-xl shadow-red-200 transition transform hover:-translate-y-1 active:scale-95">
                            Recept Opslaan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@php
    $options = '';
    foreach ($producten as $p) {
        $options .= "<option value=\"{$p->id}\">{$p->naam}</option>";
    }
@endphp

<script>
    const container = document.getElementById('ingredienten-container');
    const addBtn = document.getElementById('add-ingredient');
    const productOptions = `{!! $options !!}`;

    function addIngredientRow() {
        const index = container.children.length;
        const div = document.createElement('div');
        div.className = 'grid grid-cols-1 md:grid-cols-12 gap-4 p-5 bg-white border border-red-100 rounded-2xl shadow-sm hover:border-red-300 transition group';

        div.innerHTML = `
            <div class="md:col-span-6">
                <label class="block text-[10px] font-black text-gray-400 uppercase mb-1">Product</label>
                <select name="ingredienten[${index}][product_id]" required
                        class="w-full rounded-xl border-gray-100 bg-gray-50 focus:bg-white focus:border-red-500 focus:ring-red-500 transition">
                    <option value="">Kies product...</option>
                    ${productOptions}
                </select>
            </div>

            <div class="md:col-span-4">
                <label class="block text-[10px] font-black text-gray-400 uppercase mb-1">Hoeveelheid</label>
                <input type="text" name="ingredienten[${index}][hoeveelheid]" required
                       placeholder="bijv. 200 g"
                       class="w-full rounded-xl border-gray-100 bg-gray-50 focus:bg-white focus:border-red-500 focus:ring-red-500 transition">
            </div>

            <div class="md:col-span-2 flex items-end justify-end">
                <button type="button" class="remove p-3 text-gray-300 hover:text-red-600 transition" title="Verwijderen">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </div>
        `;

        div.querySelector('.remove').onclick = () => {
            div.classList.add('opacity-0', 'scale-95');
            setTimeout(() => div.remove(), 200);
        };
        container.appendChild(div);
    }

    addBtn.onclick = addIngredientRow;
    addIngredientRow(); // Start met 1 rij
</script>
@endsection