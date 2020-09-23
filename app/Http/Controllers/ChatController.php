<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
     public function chat_create(Request $request){
        $user = JWTAuth::authenticate();
        $chats = new Chat();
        $chats->number = $request->input('number');
        $chats->description = $request->input('description');
        $chats->save();
}}
