<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionPartenaire extends Model
{
    use HasFactory;
    protected $fillable = [
        'sender',
        'receiver',
        'amount',
        'type',
        'description',
    ];


    public function Sender()
    {
        return $this->belongsTo(Enrole::class, 'sender')->with('Personne_a_prevenir')
            ->with('Antecedants');
    }

    public function Receiver()
    {
        return $this->belongsTo(User::class, 'receiver');
    }
}
