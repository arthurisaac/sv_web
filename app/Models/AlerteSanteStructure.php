<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlerteSanteStructure extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'contact',
        'image',
    ];

    public function SanteCategories() {
        return $this->hasMany(AlerteSanteStructureCategorie::class, 'id_structure');
    }
}
