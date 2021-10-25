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
		$question4 = new Question;

		$question1->prompt = "What never fails to put a smile on your face?";
		$question1->badges = "Vines,Cat videos,Memes";
		$question1->save();

		$question2->prompt = "Share something that warms your heart 🥺";
		// $question2->badges = "something,something";
		$question2->save();

		$question3->prompt = "What's something that gets you feeling creative?";
		// $question3->badges = "something,something";
		$question3->save();

		$question4->prompt = "Share your favorite music 🎶";
		$question4->prompt2 = "When did you first hear this song? What does it mean to you?";
		$question4->save();

		return true;
	}

	public function GetAll(){
		$questions = Question::all();
		return $questions;
	}
}
