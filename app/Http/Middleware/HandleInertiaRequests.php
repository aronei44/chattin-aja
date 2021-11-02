<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Inertia\Middleware;
use App\Models\User;
use App\Models\Chat;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        // You are really good dev if you get here in 1 day. haha
        // in this middleware, you can to send any data to all pages you have. no problem it's react or vue 
        $users = [];
        if(Auth::user()){
            
            foreach(Chat::where('user1_id',Auth::user()->id)->get() as $chat){
                $user = User::find($chat->user2_id);
                $users[]=[
                    'name'=>$user->name,
                    'email'=>$user->mail,
                    'id'=>$user->id
                ];
            }
            foreach(Chat::where('user2_id',Auth::user()->id)->get() as $chat){
                $user = User::find($chat->user1_id);
                $users[]=[
                    'name'=>$user->name,
                    'email'=>$user->mail,
                    'id'=>$user->id
                ];
            }
        }

        return array_merge(parent::share($request), [
            'users'=> $users, // i want to share all users data if user has any chat with log user
            'user' => Auth::user(), // this is just Auth::user()
            'csrf' => csrf_token()  // in laravel there must be csrf token every post form
        ]);
    }
}
