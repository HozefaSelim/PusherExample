<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function notify(){

        $user = User::find(2);
       // $notifications = $user->notifications()->get();
        $notifications = $user->unreadNotifications()->get();

        $user->unreadNotifications->markAsRead();
       foreach($notifications as $noti){
        dd($noti->data['title']);
       }
    }
}
