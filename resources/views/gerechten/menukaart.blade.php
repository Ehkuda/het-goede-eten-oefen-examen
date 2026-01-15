@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-8">
                        <h1 class="text-3xl font-bold text-center flex-1">Menukaart - Het Goede Eten</h1>
                    </div>

                    @if ($gerechten->isEmpty())
                        <p class="text-center text-gray-500 py-12 text-xl">
                            Er staan nog geen gerechten op de menukaart.
                        </p>
                    @else
                        @foreach ($gerechten->groupBy('categorie.naam') as $categorieNaam => $groep)
                            <div class="mb-12">
                                <h2 class="text-2xl font-semibold text-gray-800 mb-4 border-b pb-2">
                                    {{ $categorieNaam }}
                                </h2>

                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                    @foreach ($groep as $gerecht)
                                        <div class="bg-gray-50 p-6 rounded-lg shadow hover:shadow-md transition-shadow">
                                            <h3 class="text-xl font-medium text-gray-900 mb-2">
                                                {{ $gerecht->naam }}
                                            </h3>

                                            @if ($gerecht->bereidingstijd_minuten)
                                                <p class="text-sm text-gray-600 mb-3">
                                                    Bereidingstijd: {{ $gerecht->bereidingstijd_minuten }} minuten
                                                </p>
                                            @endif

                                            @if ($gerecht->bereidingswijze)
                                                <p class="text-gray-700 text-sm leading-relaxed">
                                                    {{ Str::limit($gerecht->bereidingswijze, 120) }}
                                                </p>
                                            @endif

                                            <p class="mt-4 font-semibold text-indigo-600">
                                                € {{ number_format(15.95, 2, ',', '.') }} <!-- voorbeeldprijs – later uit database halen -->
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    @endif

                    <div class="text-center mt-12">
                        <a href="{{ route('gerechten.print') }}" target="_blank"
                           class="inline-block bg-indigo-600 text-white px-8 py-4 rounded-lg hover:bg-indigo-700 text-lg">
                            Menukaart printen
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection