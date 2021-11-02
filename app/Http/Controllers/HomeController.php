<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Pesan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;


class HomeController extends Controller
{
    // This function for route '/' with method get
    public function getIndex(){
        return Inertia::render('Index');
    }

    // This function for route '/' with method post
    public function postIndex(Request $request){

        // search row where user1_id is log user
        $chat = Chat::where('user1_id',Auth::user()->id)
            ->where('user2_id',$request->id)
            ->first();

        // search row where user2_id is log user when nothing row founded above
        if(!$chat){
            $chat = Chat::where('user1_id',$request->id)
                ->where('user2_id',Auth::user()->id)
                ->first();
        }

        // create row with user1_id is log user when nothing row founded above
        if(!$chat){
            $chat = Chat::create([
                'user1_id'=>Auth::user()->id,
                'user2_id'=>$request->id
            ]);
        }

        // Some request contains more than id
        if($request->text){
            Pesan::create([
                'chat_id'   =>$chat->id,
                'from'      =>Auth::user()->id,
                'to'        =>$request->id,
                'body'      =>$request->text
            ]);
        }

        // lets see if the log user has a chats with target user
        $user = User::find($request->id);
        $chats = [];
        $pesan = Chat::find($chat->id);
        foreach ($pesan->pesans as $pesan) {
            $date = explode(' ', $pesan->created_at);
            $chats[]=[
                'id' => $pesan->id,
                'text'=> $pesan->body,
                'from'=> $pesan->from,
                'to'=> $pesan->to,
                'date'=>$date[0],
                'clock'=>$date[1]
            ];
        }

        // just return it!!!
        return Inertia::render('Index',[
            'name'=>$user->name,
            'id'=>$user->id,
            'chats'=>$chats
        ]);
    }
}
