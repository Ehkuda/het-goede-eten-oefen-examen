@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold">Receptenlijst</h1>
                        
                        <div class="space-x-4">
                            <a href="{{ route('gerechten.print') }}" target="_blank"
                               class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                                Print lijst
                            </a>
                            
                            <a href="{{ route('gerechten.create') }}"
                               class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                                Nieuw recept toevoegen
                            </a>
                        </div>
                    </div>

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($gerechten->isEmpty())
                        <p class="text-gray-500 text-center py-8">Er zijn nog geen recepten toegevoegd.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Naam</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categorie</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bereidingstijd</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acties</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($gerechten as $gerecht)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $gerecht->naam }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                    {{ $gerecht->categorie->naam ?? 'Onbekend' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $gerecht->bereidingstijd_minuten ? $gerecht->bereidingstijd_minuten . ' min' : '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('gerechten.show', $gerecht) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Bekijk</a>
                                                <a href="{{ route('gerechten.edit', $gerecht) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">Wijzig</a>
<form action="{{ route('gerechten.destroy', $gerecht) }}" method="POST" class="inline-block">
    @csrf
    @method('DELETE')
    <button type="submit"
            class="text-red-600 hover:text-red-900 font-medium"
            onclick="return confirm('Weet je zeker dat je \"{{ addslashes($gerecht->naam) }}\" wilt verwijderen? Dit kan niet ongedaan gemaakt worden.');">
        Verwijder
    </button>
</form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection