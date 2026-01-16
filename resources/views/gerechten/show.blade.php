@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-2xl rounded-3xl overflow-hidden border border-red-100">
            <div class="bg-red-600 p-8 text-white flex justify-between items-center">
                <div>
                    <p class="text-red-200 text-xs font-black uppercase tracking-widest mb-1">{{ $gerecht->categorie->naam ?? 'Recept' }}</p>
                    <h1 class="text-4xl font-black italic">{{ $gerecht->naam }}</h1>
                </div>
                <a href="{{ route('gerechten.index') }}" class="bg-white/20 hover:bg-white/30 px-4 py-2 rounded-xl font-bold transition">← Terug</a>
            </div>

            <div class="p-10 grid grid-cols-1 md:grid-cols-3 gap-10">
                <div class="md:col-span-2">
                    <h3 class="text-2xl font-black text-gray-900 mb-4 border-b-2 border-red-100 pb-2 italic">Bereidingswijze</h3>
                    <p class="text-gray-700 leading-relaxed text-lg whitespace-pre-line">
                        {{ $gerecht->bereidingswijze }}
                    </p>
                </div>

                <div class="bg-red-50 p-6 rounded-2xl border border-red-100">
                    <h3 class="text-lg font-black text-red-600 mb-4 uppercase tracking-tighter">🥘 Ingrediënten</h3>
                    <ul class="space-y-3">
                        @foreach($gerecht->ingredienten as $ingredient)
                            <li class="flex justify-between border-b border-red-200/50 pb-2">
                                <span class="font-bold text-gray-800">{{ $ingredient->product->naam }}</span>
                                <span class="text-red-600 font-medium">{{ $ingredient->hoeveelheid }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection