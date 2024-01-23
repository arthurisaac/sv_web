<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Alerte extends Model
{
    use HasFactory;
    protected $table = 'sauvie_alertes';

    protected $fillable = [
        'alerte_user',
        'alerte',
        'vue',
        'attribue_a',
        'traite',
        'latitude',
        'longitude',
    ];

    public function alerteUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'alerte_user');
    }
}
