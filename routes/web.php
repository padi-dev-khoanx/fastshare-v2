<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TextController;
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
Route::get('/', 'HomeController@index')->name('home.index');

Route::get('/login', 'UserController@login')->name('user.login');
Route::get('/register', 'UserController@register')->name('user.register');
Route::post('/auth', 'UserController@auth')->name('user.auth');
Route::post('/create', 'UserController@create')->name('user.create');
Route::get('/logout', 'UserController@logout')->name('user.logout');
Route::get('/account', 'UserController@account')->name('user.account');

Route::get('/text', 'TextController@index')->name('text.index');
Route::post('/text/submit', 'TextController@submit')->name('text.submit');
Route::get('/text/{path}', 'TextController@show')->name('text.show ');

Route::post('/upload_file', 'HomeController@upload')->name('home.upload');
Route::get('/{path}', 'HomeController@download');
Route::get('/preview/{path}', 'HomeController@preview')->name('previewFile');
Route::post('/download', 'HomeController@downloadFile');
Route::post('/delete_file', 'HomeController@delete')->name('home.delete');
