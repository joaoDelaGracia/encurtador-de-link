<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $fillable = [
        'user_id',
        'original_url',
        'short_code',
        'title',
        'status',
        'expires_at'
    ];

    public function analytics()
    {
        return $this->hasMany(Analytic::class);
    }
    
}
