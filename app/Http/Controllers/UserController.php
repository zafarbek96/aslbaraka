<?php

namespace App\Http\Controllers;
use App\User;
use App\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }

        $credentials = $request->only('name', 'password');

        try {
          if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'invalid_credentials'], 400);
          }
        } catch (JWTException $e) {
          return response()->json(['error' => 'could_not_create_token'], 500);
        }


        if (!$token) {
          return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = User::where('name', $request->name)
        ->first();

        $response = [
          'user' => $user,
          'token' => $token,

        ];
        return response()->json($response, 200);
    }
    public function create(Request $request){

    }
    public function show(){
    	$users  = User::all();
    	return response()->json($users);
    }
    public function showapi(Request $request){
       $users = User::where('number', '=', $request->number)->where('code', $request->code)->get();
       // $users= User::where('number', $request->number)->get();
        //$users = User::where('code', $request->code)->get();
        return response()->json($users);
    }

    public function chat_create(Request $request){
        $user = JWTAuth::authenticate();
        $user_id = $user->name;
        $chats = new Chat();
        $chats->name = $user_id;
        $chats->number = $request->input('number');
        $chats->description = $request->input('description');
        $chats->save();
        $response = [
                'msg'      => 'list',
                           ];
            return response()->json($response,200);
}
}
