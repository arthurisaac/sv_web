<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AlerteMessage extends Model
{
    use HasFactory;
    protected $fillable = [
        'user',
        'toUser',
        'message_type',
        'message',
        'attachment',
        'seen',
        'discussion',
    ];


    public function alerteUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user');
    }
}
