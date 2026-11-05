<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Analytic extends Model
{
    protected $fillable = [
        'link_id',
        'clicked_at',
        'referrer',
        'user_agent',
        'ip_hash',
        'country',
        'device_type'
    ];

    public function link(): BelongsTo
    {
        return $this->belongsTo(Link::class);
    }

}
