<?php

namespace App\Http\Controllers;
use App\User;
use App\Present;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\DB;

class PresentController extends Controller
{
    public function showapi(Request $request){
    	$user = JWTAuth::authenticate();
    	$user_id = $user->id;
    	$users = User::where('id', $user_id)
        	->select('users.name', 'users.ball')
        	->get();
        return response()->json( ['user'=>$users, 'aksiya'=> Present::all()] );
    }
}
