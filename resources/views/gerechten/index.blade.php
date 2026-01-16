@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-2xl rounded-3xl border border-red-100">
            <div class="p-8">
                <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-4">
                    <h1 class="text-4xl font-black text-gray-900 tracking-tight">Recepten<span class="text-red-600">beheer</span></h1>
                    <div class="flex space-x-3">
                        <a href="{{ route('gerechten.print') }}" target="_blank" class="bg-white border-2 border-red-600 text-red-600 px-5 py-2 rounded-xl font-bold hover:bg-red-50 transition">
                            🖨️ Print Lijst
                        </a>
                        <a href="{{ route('gerechten.create') }}" class="bg-red-600 text-white px-5 py-2 rounded-xl font-bold hover:bg-red-700 shadow-lg shadow-red-200 transition transform hover:scale-105">
                            + Nieuw Recept
                        </a>
                    </div>
                </div>

                @if (session('success'))
                    <div class="bg-green-50 border-l-4 border-green-500 text-green-800 p-4 rounded-lg mb-8 animate-pulse">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full italic-header">
                        <thead>
                            <tr class="border-b-2 border-red-100">
                                <th class="px-6 py-4 text-left text-xs font-black text-red-600 uppercase tracking-widest">Gerecht</th>
                                <th class="px-6 py-4 text-left text-xs font-black text-red-600 uppercase tracking-widest">Categorie</th>
                                <th class="px-6 py-4 text-left text-xs font-black text-red-600 uppercase tracking-widest">Tijd</th>
                                <th class="px-6 py-4 text-right text-xs font-black text-red-600 uppercase tracking-widest">Acties</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($gerechten as $gerecht)
                                <tr class="hover:bg-red-50/50 transition">
                                    <td class="px-6 py-5 whitespace-nowrap font-bold text-gray-800 text-lg">{{ $gerecht->naam }}</td>
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <span class="px-3 py-1 text-xs font-bold rounded-full bg-red-100 text-red-700 uppercase">
                                            {{ $gerecht->categorie->naam ?? 'Overig' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap text-gray-500 font-medium">
                                        {{ $gerecht->bereidingstijd_minuten ?? '-' }} min
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap text-right space-x-2">
                                        <a href="{{ route('gerechten.show', $gerecht) }}" class="text-blue-600 font-bold hover:underline">Bekijk</a>
                                        <a href="{{ route('gerechten.edit', $gerecht) }}" class="text-orange-600 font-bold hover:underline">Edit</a>
                                        <form action="{{ route('gerechten.destroy', $gerecht) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 font-bold hover:underline" onclick="return confirm('Verwijderen?')">Wis</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection