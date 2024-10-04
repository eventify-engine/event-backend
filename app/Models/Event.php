<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function threads(): HasMany
    {
        return $this->hasMany(Thread::class);
    }
}
