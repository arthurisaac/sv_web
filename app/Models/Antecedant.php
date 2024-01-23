<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Antecedant extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_enrole',
        'id_groupe',
        'prescription',
        'description',
    ];
}
