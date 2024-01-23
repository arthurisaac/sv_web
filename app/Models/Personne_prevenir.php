<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personne_prevenir extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'contact',
        'image',
    ];
}
