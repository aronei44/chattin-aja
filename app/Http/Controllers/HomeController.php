<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Pesan;
use Illuminate\Http\Request;
use App\Events\MessageNotification;
use Illuminate\Support\Facades\Auth;


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
            $pesan = Pesan::create([
                'chat_id'   =>$chat->id,
                'from'      =>Auth::user()->id,
                'to'        =>$request->id,
                'body'      =>$request->text
            ]);
            event(new MessageNotification(['from'=>$pesan->from,'to'=>$pesan->to]));
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
    public function getUser(){
        $users = [];
        if(Auth::user()){
            $pesans =[];
            foreach(Pesan::orderBy('id','desc')->get() as $pesan){
                if($pesan->from == Auth::user()->id || $pesan->to == Auth::user()->id){
                    if (!in_array($pesan->chat_id, $pesans)){
                        $pesans[]=$pesan->chat_id;
                    }
                }
            }
            $chats=[];
            foreach($pesans as $chat){
                $chat = Chat::find($chat);
                if($chat->user1_id==Auth::User()->id){
                    $chats[]=$chat->user2_id;
                }else{
                    $chats[]=$chat->user1_id;

                }
            }
            foreach($chats as $chat){
                $user = User::find($chat);
                $users[]=[
                    'name'=>$user->name,
                    'email'=>$user->email,
                    'id'=>$user->id
                ];
            }
        }
        return $users;
    }
}
