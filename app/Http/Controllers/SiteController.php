<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\models\Site;

class SiteController extends Controller
{
	public function GetActiveSites(){
		// return Site::all()->where('active', true);
		return "hi";
	}
}
