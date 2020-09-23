<?php

namespace App\Http\Controllers;
use App\Type;
use App\Product;
use Illuminate\Http\Request;

class TurlarController extends Controller
{
    public function getAll(Request $request){

    	$type = Type::all();

    	
        $  = Product::where('type', '')->get();
        $  = Product::where('type', '')->get();

        $result = [
            '' => $kalbasa,
            '' => $sasiska,

        ];
        return response()->json($type);
    }
}
