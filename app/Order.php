<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Order extends Model
{
    public function product(){
        return $this->belongsTo('App\Product');
    }
    public  function buy(){
        return $this->belongsTo('App\Buy');
    }
     public function typeName(){
    	return $this->belongsTo('App\Type', 'type');
    }
}
