<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AlerteDiscussion extends Model
{
    use HasFactory;
    protected $fillable = [
        'alerte_user_regular',
        'alerte_user_agent',
        'subject',
    ];

    public function AlerteUserRegular(): BelongsTo
    {
        return $this->belongsTo(User::class, 'alerte_user_regular');
    }

    public function AlerteUserAgent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'alerte_user_agent');
    }

    public function LatestMessage(): HasOne
    {
        return $this->hasOne(AlerteMessage::class, 'discussion');
    }
}
