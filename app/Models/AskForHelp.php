<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AskForHelp extends Model
{
    use HasFactory;
    protected $fillable = [
        'emitteur',
        'recepteur',
        'amount',
    ];
}
