<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;

class QuestionController extends Controller
{
	public function seedQuestions(Request $request){
		$question1 = new Question;
		$question2 = new Question;
		$question3 = new Question;


		$question1->prompt = "Share something that makes you smile!";
		$question1->badges = "Vines,Cat videos,Memes";
		$question1->save();

		$question2->prompt = "Share something that warms your heart 🥰";
		$question2->badges = "something,something";
		$question2->save();

		$question3->prompt = "Share something creative that inspires you 💡";
		$question3->badges = "something,something";
		$question3->save();

		return true;
	}

	public function GetAll(){
		$questions = Question::all();
		return $questions;
	}
}
