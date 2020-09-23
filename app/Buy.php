<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\BuyScope;


class Buy extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new BuyScope);
    }
}
