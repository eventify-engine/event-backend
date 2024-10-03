<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    protected $fillable = [
        'conference_id',
        'name'
    ];

    public function conference(): BelongsTo
    {
        return $this->belongsTo(Conference::class);
    }
}
