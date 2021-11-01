<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/user/{name}', function ($name){
	$data = User::where('name','like','%'.$name.'%')->get();
	$users = [];
	foreach ($data as $user) {
		$users[]=[
			'id'=>$user->id,
			'name'=>$user->name,
			'email'=>$user->email
		];
	}
	return $users;
});

