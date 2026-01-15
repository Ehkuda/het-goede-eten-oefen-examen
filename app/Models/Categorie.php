<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;

    protected $table = 'categorieen';  // belangrijk als je migratie 'categorieen' heet!

    protected $fillable = [
        'naam',
    ];

    public function gerechten()
    {
        return $this->hasMany(Gerecht::class);
    }
}