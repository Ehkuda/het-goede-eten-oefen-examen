<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gerecht extends Model
{
    use HasFactory;

    protected $table = 'gerechten';

    protected $fillable = [
        'naam',
        'categorie_id',
        'bereidingswijze',
        'bereidingstijd_minuten',
    ];

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function ingredienten()
    {
        return $this->hasMany(Ingredient::class);
    }
}