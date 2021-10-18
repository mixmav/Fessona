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

Route::post('/api/auth/model/balloon/create', 'BalloonController@Create');
Route::post('/api/auth/model/balloon/get-all-for-question', 'BalloonController@GetAllForQuestion');


Route::get('/{all}', 'HomeController@Home')->where(['all' => '.*?']);