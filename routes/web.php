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

Route::get('/admin', 'AdminController@Home')->name('AdminHome');
Route::get('/admin/approve/{balloon}', 'AdminController@ApproveBalloon');
Route::get('/admin/reject/{balloon}', 'AdminController@RejectBalloon');

Route::post('/admin/login', 'AuthController@Login');
Route::get('/admin/login', 'AuthController@LoginPage')->name('login');
Route::get('/admin/logout', 'AuthController@Logout');

Route::post('/api/model/balloon/create', 'BalloonController@Create');
Route::post('/api/model/balloon/get-all-for-question', 'BalloonController@GetAllForQuestion');
Route::post('/api/model/balloon/get-balloon-data', 'BalloonController@GetBalloonData');
Route::post('/api/model/balloon/update-like', 'BalloonController@UpdateLike');

Route::post('/api/model/question/get-all', 'QuestionController@GetAll');

Route::get('/test/seed-questions', 'QuestionController@seedQuestions');
// Route::get('/test/seed-balloons', 'BalloonController@seedBalloons');

Route::get('/{all}', 'HomeController@Home')->where(['all' => '.*?']);