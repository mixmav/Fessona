<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{

	public function __construct(){
		$this->middleware('auth');
		
	}

	public function Home(){
		// return view('admin.login');
	}
}
