<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use App\Events\chatSend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function chatForm($id){
        $receiver = User::find($id);
        return view('chat' ,compact('receiver'));

    }
    
    public function sendMessage(Request $request , $id){
        $messagetext = $request->input('message');
        $senderId = Auth::id();

        Message::create([
            'sender' =>  $senderId,
            'receiver' =>  $id,
            'message' =>  $messagetext,
            
        ]);

        broadcast(new chatSend( $id ,    $messagetext))->toOthers();

        return "message successfully sent";

    }

}
