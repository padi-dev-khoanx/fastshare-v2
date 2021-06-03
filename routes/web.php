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
Route::get('/text', 'TextController@index')->name('text.index');
Route::post('/text/submit', 'TextController@submit')->name('text.submit');
Route::get('/text/{path}', 'TextController@show')->name('text.show ');

Route::get('/', 'HomeController@index')->name('home.index');
Route::post('/upload_file', 'HomeController@upload')->name('home.upload');
Route::get('/{path}', 'HomeController@download');
Route::get('/preview/{path}', 'HomeController@preview')->name('previewFile');
Route::post('/download', 'HomeController@downloadFile');
Route::post('/delete_file', 'HomeController@delete')->name('home.delete');
