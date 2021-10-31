<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Chat;
use App\Models\Pesan;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', function () {
    return Inertia::render('Index');
})->name('home')->middleware('auth');

Route::post('/', function (Request $request) {
	$chat = Chat::where('user1_id',Auth::user()->id)
			->where('user2_id',$request->id)
			->first() or Chat::where('user1_id',$request->id)
			->where('user2_id',Auth::user()->id)
			->first();
	if(!$chat){
		$chat = Chat::create([
			'user1_id'=>Auth::user()->id,
			'user2_id'=>$request->id
		]);
	}
	if($request->text){
		Pesan::create([
			'chat_id'	=>$chat->id,
			'from'		=>Auth::user()->id,
			'to'		=>$request->id,
			'body'		=>$request->text
		]);
	}
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
    return Inertia::render('Index',[
    	'name'=>$user->name,
    	'id'=>$user->id,
    	'chats'=>$chats
    ]);
})->middleware('auth');

