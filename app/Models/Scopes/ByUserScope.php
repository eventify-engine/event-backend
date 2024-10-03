<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ByUserScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        if (!($user = request()->user()))
            return;

        $builder->where('user_id', $user->id);
    }
}
