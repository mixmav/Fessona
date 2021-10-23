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

		return true;
	}

	public function GetAllForQuestion(Request $request){
		$balloons = Balloon::where('question_id', $request->questionID)->latest()->get(['id', 'likes']);
		return $balloons;
	}

	public function GetBalloonData(Request $request){
		$balloon = Balloon::where('id', $request->balloonID)->with('question')->first();
		return $balloon;
	}

	public function UpdateLike(Request $request){
		$balloon = Balloon::where('id', $request->balloonID)->first();
		

		if($request->val == "true"){
			$newLikes = $balloon->likes + 1;
		} else if($request->val == "false"){
			$newLikes = $balloon->likes - 1;
		}

		if ($newLikes < 0) {
			$newLikes = 0;
		}

		$balloon->likes = $newLikes;
		$balloon->save();
		
		return $newLikes;
	}

	public function seedBalloons(){
		
		for ($i=1; $i <=4 ; $i++) { 
			for ($j=1; $j <= 100 ; $j++) { 
				$balloon = new Balloon;
				$balloon->content = "This is a test";
				$balloon->question_id = $i;
				$balloon->save();
			}
		}
		return true;
	}
}
