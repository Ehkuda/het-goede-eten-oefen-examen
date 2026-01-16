@extends('layouts.app')

@section('content')
    <div class="py-12 bg-red-50/30 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl rounded-3xl border border-red-100">
                <div class="p-8 md:p-12 text-gray-900">
                    
                    <div class="text-center mb-16">
                        <h1 class="text-5xl font-black text-red-600 italic tracking-tighter uppercase mb-4">
                            Menukaart
                        </h1>
                        <div class="flex items-center justify-center space-x-4">
                            <div class="h-px w-12 bg-red-200"></div>
                            <span class="text-gray-400 font-bold tracking-widest uppercase text-xs">Het Goede Eten</span>
                            <div class="h-px w-12 bg-red-200"></div>
                        </div>
                    </div>

                    @if ($gerechten->isEmpty())
                        <div class="text-center py-20 bg-gray-50 rounded-3xl border-2 border-dashed border-red-100">
                            <p class="text-gray-400 text-xl font-medium italic">
                                Onze chef bereidt momenteel nieuwe creaties.<br>
                                <span class="text-sm not-italic font-bold text-red-600 uppercase tracking-widest mt-2 block italic">Kom snel terug!</span>
                            </p>
                        </div>
                    @else
                        @foreach ($gerechten->groupBy('categorie.naam') as $categorieNaam => $groep)
                            <div class="mb-20 last:mb-12">
                                <div class="flex items-center mb-10">
                                    <h2 class="text-3xl font-black text-gray-900 italic pr-6 bg-white z-10">
                                        {{ $categorieNaam }}
                                    </h2>
                                    <div class="flex-1 h-px bg-red-100"></div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                                    @foreach ($groep as $gerecht)
                                        <div class="relative group bg-white p-8 rounded-3xl border border-red-50 shadow-sm hover:shadow-xl hover:border-red-200 transition-all duration-300">
                                            <div class="absolute top-0 right-0 p-4 opacity-0 group-hover:opacity-100 transition-opacity">
                                                <span class="text-red-100 text-4xl">🥘</span>
                                            </div>

                                            <h3 class="text-2xl font-black text-gray-800 mb-2 group-hover:text-red-600 transition-colors">
                                                {{ $gerecht->naam }}
                                            </h3>

                                            @if ($gerecht->bereidingstijd_minuten)
                                                <div class="flex items-center text-red-600/60 text-xs font-black uppercase tracking-widest mb-4">
                                                    <span class="mr-2">⏱️</span>
                                                    {{ $gerecht->bereidingstijd_minuten }} minuten
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    @endif

                    <div class="text-center mt-16 pt-12 border-t border-red-100">
                        <a href="{{ route('gerechten.print') }}" target="_blank"
                           class="inline-flex items-center bg-red-600 text-white px-10 py-4 rounded-2xl font-black uppercase tracking-widest hover:bg-red-700 shadow-xl shadow-red-200 transition-all transform hover:scale-105 active:scale-95">
                            <span class="mr-3 text-xl">🖨️</span> Menukaart Printen
                        </a>
                        <p class="text-gray-400 text-xs mt-6 font-bold uppercase tracking-tighter">© {{ date('Y') }} - Het Goede Eten</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection