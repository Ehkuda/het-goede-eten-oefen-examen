@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto py-12">
    <h1 class="text-2xl font-bold mb-6">Tweefactor Verificatie</h1>
    
    <p class="mb-4 text-gray-600">
        We hebben een verificatiecode naar je e-mail gestuurd.
    </p>

    <form method="POST" action="{{ url('/two-factor-challenge') }}">
        @csrf

        <div class="mb-4">
            <label for="code" class="block mb-2">Verificatiecode</label>
            <input 
                type="text" 
                name="code" 
                id="code" 
                class="w-full border rounded px-4 py-2"
                required 
                autofocus
            >
            @error('code')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="w-full bg-indigo-600 text-white px-6 py-3 rounded">
            Verifiëren
        </button>
    </form>
</div>
@endsection