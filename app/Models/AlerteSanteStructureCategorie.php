<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlerteSanteStructureCategorie extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_structure',
        'nom',
        'image',
    ];

    public function SanteStructure() {
        return $this->belongsTo(AlerteSanteStructure::class, 'id_structure');
    }
}
