<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Question;

class Balloon extends Model
{
	use HasFactory;

	public function getCreatedAtAttribute($value)
	{
		return \Carbon\Carbon::parse($value)->timezone('Australia/Melbourne')->toDayDateTimeString();
	}

	public function question(){
		return $this->belongsTo(Question::class);
	}
}
