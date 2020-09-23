<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    public function typeName(){
    	return $this->belongsTo('App\Type', 'type');
    }
}
