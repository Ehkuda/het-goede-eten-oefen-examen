@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8">
                    <div class="flex justify-between items-start mb-8">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">{{ $gerecht->naam }}</h1>
                            <p class="text-lg text-gray-600 mt-2">
                                {{ $gerecht->categorie->naam ?? 'Geen categorie' }}
                            </p>
                        </div>
                        <a href="{{ route('gerechten.index') }}"
                           class="px-6 py-3 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
                            Terug naar lijst
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Links: details -->
                        <div class="space-y-6">
                            @if ($gerecht->bereidingstijd_minuten)
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Bereidingstijd</h3>
                                    <p class="text-gray-700">{{ $gerecht->bereidingstijd_minuten }} minuten</p>
                                </div>
                            @endif

                            @if ($gerecht->bereidingswijze)
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Bereidingswijze</h3>
                                    <div class="prose text-gray-700">
                                        {!! nl2br(e($gerecht->bereidingswijze)) !!}
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Rechts: ingrediënten -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Ingrediënten</h3>
                            @if ($gerecht->ingrediënten->isEmpty())
                                <p class="text-gray-500 italic">Nog geen ingrediënten toegevoegd.</p>
                            @else
                                <ul class="space-y-3">
                                    @foreach ($gerecht->ingrediënten as $ingrediënt)
                                        <li class="flex justify-between items-center bg-gray-50 p-4 rounded-lg">
                                            <span class="font-medium">{{ $ingrediënt->naam }}</span>
                                            <span class="text-gray-600">{{ $ingrediënt->hoeveelheid }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>

                    <div class="mt-10 flex justify-end space-x-4">
                        <a href="{{ route('gerechten.edit', $gerecht) }}"
                           class="px-6 py-3 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">
                            Wijzig recept
                        </a>
                        <a href="{{ route('gerechten.index') }}"
                           class="px-6 py-3 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 transition">
                            Terug naar lijst
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection