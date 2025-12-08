<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdView extends Model
{
    protected $table = 'ad_views';

    protected $fillable = [
        'ad_id', 'view_date', 'ip_hash', 'session_id', 'user_id',
    ];

    public function ad(): BelongsTo
    {
        return $this->belongsTo(Ad::class);
    }
}
