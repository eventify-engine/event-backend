<?php

namespace App\Http\Resources;

use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Thread */
class ThreadResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'   => $this->id,
            'name' => $this->name
        ];
    }
}
