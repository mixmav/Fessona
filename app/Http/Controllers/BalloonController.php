<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Balloon;

class BalloonController extends Controller
{
	public function Create(Request $request){
		$balloon = new Balloon;
		
		$balloon->content = $request->content;
		$balloon->question_id = $request->questionID;
		$balloon->save();

		echo true;
	}

	public function GetAllForQuestion(Request $request){
		$balloons = Balloon::where('question_id', $request->questionID)->latest()->get();
		return $balloons;
	}
}
