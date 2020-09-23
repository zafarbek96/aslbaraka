<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class BuyScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        if( request()->has('start') && !empty(request()->get('start')) ){
            $builder->whereDate('data', '>=', request()->get('start'));
        }
        if( request()->has('end') && !empty(request()->get('end')) ){
            $builder->whereDate('data', '<=', request()->get('end'));
        }
    }
}