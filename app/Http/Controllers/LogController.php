<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class LogController extends Controller
{
    public function loginView(){
    	return Inertia::render('Login');
    }
    public function loginAuth(Request $request){
    	$credentials = $request->validate([
	        'email' => ['required', 'email'],
	        'password' => ['required'],
	    ]);

	    if (Auth::attempt($credentials)) {
	        $request->session()->regenerate();

	        return redirect()->intended('/');
	    }
	    else{
	    	return back();
	    }
    }
    public function registerView(){
    	return Inertia::render('Register');
    }
    public function store(Request $request){
    	$validatedData = $request->validate([
        'name'      => 'required|min:8|max:45|unique:users',
        'email'     => 'required|email|unique:users',
        'password'  => 'required|min:8',

	    ]);
	    $validatedData['password']  = Hash::make($validatedData['password']);
		User::create($validatedData);
	    return redirect('/login');
    }
    public function logout(Request $request){
		Auth::logout();

	    $request->session()->invalidate();

	    $request->session()->regenerateToken();

	    return redirect('/');
    }

}
