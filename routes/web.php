<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/api/sites/get-active-sites', 'SiteController@GetActiveSites');

Route::get('/admin', 'AdminController@Home');
Route::view('/admin/login', 'admin.login')->name('login');

Route::post('/api/model/balloon/create', 'BalloonController@Create');
Route::post('/api/model/balloon/get-all-for-question', 'BalloonController@GetAllForQuestion');
Route::post('/api/model/balloon/get-balloon-data', 'BalloonController@GetBalloonData');
Route::post('/api/model/balloon/update-like', 'BalloonController@UpdateLike');

Route::post('/api/model/question/get-all', 'QuestionController@GetAll');

Route::get('/test/seed-questions', 'QuestionController@seedQuestions');
// Route::get('/test/seed-balloons', 'BalloonController@seedBalloons');

Route::get('/{all}', 'HomeController@Home')->where(['all' => '.*?']);