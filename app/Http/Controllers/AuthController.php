<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class AuthController extends Controller
{
	public function __construct(){
		$this->middleware('guest', ['except' => ['Logout']]);
	}

	public function LoginPage(){
		return view('admin.login');
	}

	public function Login(Request $request){
		$credentials = $request->only('email', 'password');

		if (Auth::attempt($credentials)) {
			return redirect()->intended('/admin');
		}

		return redirect()->back();
	}

	public function Logout(){
		Auth::logout();
		return redirect('/admin');
	}
}
