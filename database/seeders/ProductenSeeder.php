<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductenSeeder extends Seeder
{
    public function run(): void
    {
        $producten = [
            ['naam' => 'Rundergehakt', 'eenheid' => 'gram'],
            ['naam' => 'Tomatensaus', 'eenheid' => 'ml'],
            ['naam' => 'Ui', 'eenheid' => 'stuk'],
            ['naam' => 'Knoflook', 'eenheid' => 'teen'],
            ['naam' => 'Pasta spaghetti', 'eenheid' => 'gram'],
            ['naam' => 'Parmezaanse kaas', 'eenheid' => 'gram'],
            ['naam' => 'Olijfolie', 'eenheid' => 'el'],
            ['naam' => 'Basilicum', 'eenheid' => 'blaadjes'],
            ['naam' => 'Slabladeren', 'eenheid' => 'stuk'],
            ['naam' => 'Komkommer', 'eenheid' => 'stuk'],
            ['naam' => 'Feta', 'eenheid' => 'gram'],
            ['naam' => 'Olijven', 'eenheid' => 'gram'],
            ['naam' => 'Kipfilet', 'eenheid' => 'gram'],
            ['naam' => 'Paprika', 'eenheid' => 'stuk'],
            ['naam' => 'Rijst', 'eenheid' => 'gram'],
            ['naam' => 'Room', 'eenheid' => 'ml'],
            ['naam' => 'Champignons', 'eenheid' => 'gram'],
            ['naam' => 'Spekjes', 'eenheid' => 'gram'],
            ['naam' => 'Aardappelen', 'eenheid' => 'gram'],
            ['naam' => 'Wortel', 'eenheid' => 'stuk'],
        ];

        foreach ($producten as $product) {
            Product::create($product);
        }
    }
}