<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Balloon;

class AdminController extends Controller
{

	public function __construct(){
		$this->middleware('auth');
		
	}

	public function Home(){
		$unapproved_balloons = Balloon::where('approved', false)->where('rejected', false)->oldest()->get();
		return view('admin.home', ['unapproved_balloons' => $unapproved_balloons]);
	}

	public function ApproveBalloon(Balloon $balloon){
		$balloon->approved = true;
		$balloon->save();
		return redirect()->route('AdminHome');
	}

	public function RejectBalloon(Balloon $balloon){
		$balloon->rejected = true;
		$balloon->save();
		return redirect()->route('AdminHome');
	}
}
