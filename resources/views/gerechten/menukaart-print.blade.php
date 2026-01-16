<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Menukaart - Het Goede Eten</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        @page {
            margin: 1cm;
            size: A4;
        }
        body {
            font-family: 'Georgia', serif; /* Serif font oogt klassieker op print */
            background-color: white !important;
        }
        .page-break {
            page-break-before: always;
        }
        .gerecht-card {
            break-inside: avoid;
            border-bottom: 1px solid #fee2e2; /* Lichtrode scheidingslijn */
        }
        /* Zorg dat kleuren goed printen */
        * {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
    </style>
</head>
<body class="bg-white text-gray-900">

    <div class="max-w-4xl mx-auto py-8 px-10">
        <div class="text-center mb-12 border-b-4 border-red-600 pb-6">
            <h1 class="text-5xl font-black text-red-600 uppercase tracking-tighter italic mb-2">Het Goede Eten</h1>
        </div>

        @if ($gerechten->isEmpty())
            <p class="text-center text-gray-400 italic py-20 text-xl">Momenteel geen gerechten beschikbaar op de kaart.</p>
        @else
            @foreach ($gerechten->groupBy('categorie.naam') as $categorieNaam => $groep)
                <div class="mb-12">
                    <div class="flex items-center mb-6">
                        <h2 class="text-2xl font-black text-red-700 italic pr-4 uppercase tracking-tight">
                            {{ $categorieNaam }}
                        </h2>
                        <div class="flex-1 h-px bg-red-200"></div>
                    </div>

                    <div class="grid grid-cols-1 gap-6">
                        @foreach ($groep as $gerecht)
                            <div class="gerecht-card pb-6">
                                <div class="flex justify-between items-baseline mb-2">
                                    <h3 class="text-xl font-bold text-gray-800">{{ $gerecht->naam }}</h3>
                                </div>

                                @if ($gerecht->bereidingswijze)
                                    <p class="text-gray-600 text-sm leading-relaxed mb-2 italic">
                                        {{ Str::limit($gerecht->bereidingswijze, 200) }}
                                    </p>
                                @endif

                                @if ($gerecht->bereidingstijd_minuten)
                                    <p class="text-[10px] text-gray-400 uppercase font-bold tracking-widest">
                                        ⏱ Bereidingstijd: {{ $gerecht->bereidingstijd_minuten }} min
                                    </p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @endif

        <div class="mt-20 text-center border-t border-gray-100 pt-8">
            <p class="text-gray-400 text-sm italic">Smakelijk eten!</p>
            <p class="text-gray-300 text-[10px] mt-2 tracking-widest uppercase font-bold">
                {{ date('d-m-Y') }} — www.hetgoedeeten.nl
            </p>
        </div>
    </div>

    <script>
        window.onload = function() {
            // window.print(); 
        };
    </script>
</body>
</html>