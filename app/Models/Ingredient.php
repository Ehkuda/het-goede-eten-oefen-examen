<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $table = 'ingredienten';

    protected $fillable = [
        'gerecht_id',
        'product_id',
        'hoeveelheid',
    ];

    public function gerecht()
    {
        return $this->belongsTo(Gerecht::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}