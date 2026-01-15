<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingrediënt extends Model
{
    protected $table = 'ingrediënten';  // ← exact zoals in migratie!

    protected $fillable = [
        'gerecht_id',
        'naam',
        'hoeveelheid',
    ];
}