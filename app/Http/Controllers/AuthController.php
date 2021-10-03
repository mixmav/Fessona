<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
	public function __construct(){
		$this->middleware('guest', ['except' => ['Logout']]);
	}

	public function Login(Request $request){
		$password = $request->password;

		foreach (User::all() as $user) {
			if(\Hash::check($password, $user->password)){
				Auth::login($user);
				return redirect('/');
			}
		}

		return redirect()->back();
	}

	public function Logout(){
		Auth::logout();
		return redirect('/');
	}
}
