<?php

namespace App\Http\Controllers;

use App\Type;
use App\Product;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    public function show(){
        $types = Type::all();
        return response()->json($types);
    }

    public function getAll(Request $request){

    	

    	
        $data = Type::with('products')->get();
        return response()->json($data);
    }
}
