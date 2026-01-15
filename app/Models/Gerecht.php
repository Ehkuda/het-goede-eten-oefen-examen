<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gerecht extends Model
{
    use HasFactory;

    protected $table = 'gerechten';  // ← Dit lost het op!

    // Optioneel: als je andere kolommen wilt vullen via mass assignment
    protected $fillable = [
        'naam',
        'categorie_id',
        'bereidingswijze',
        'bereidingstijd_minuten',
    ];

    // Relatie met categorie (als je die al hebt)
    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

     public function ingrediënten()
    {
        return $this->hasMany(Ingrediënt::class, 'gerecht_id');
    }
}