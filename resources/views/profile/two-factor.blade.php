@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto py-12">
        <h1 class="text-3xl font-bold mb-8">Tweefactorauthenticatie beheren</h1>

        @if (auth()->user()->two_factor_confirmed_at)
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                ✅ 2FA is actief sinds {{ auth()->user()->two_factor_confirmed_at->format('d-m-Y H:i') }}
            </div>

            <form method="POST" action="{{ route('two-factor.disable') }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 text-white px-6 py-3 rounded hover:bg-red-700">
                    2FA uitschakelen
                </button>
            </form>
        @else
            <div class="mb-6 p-4 bg-yellow-100 text-yellow-800 rounded">
                ⚠️ 2FA is momenteel uitgeschakeld
            </div>
            
            <p class="mb-6">Schakel tweefactorauthenticatie in voor extra beveiliging.</p>

            <form method="POST" action="{{ route('two-factor.enable') }}">
                @csrf
                <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded hover:bg-indigo-700">
                    2FA inschakelen
                </button>
            </form>
        @endif

        @if (session('status'))
            <div class="mt-6 p-4 bg-green-100 text-green-800 rounded">
                {{ session('status') }}
            </div>
        @endif
    </div>
@endsection