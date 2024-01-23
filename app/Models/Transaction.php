<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'sender',
        'receiver',
        'partenaire',
        'amount',
        'type',
        'description',
    ];


    /**
    * The attributes that should be cast.
    *
    * @var array
    */
    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i',
    ];

    public function Sender() {
        return $this->belongsTo(Enrole::class, 'sender')->with("Personne_a_prevenir")
        ->with("Antecedants");
    }

    public function Receiver() {
        return $this->belongsTo(Enrole::class, 'receiver')->with("Personne_a_prevenir")
        ->with("Antecedants");
    }

    public function Partenaire() {
        return $this->belongsTo(User::class, 'partenaire');
    }
}
