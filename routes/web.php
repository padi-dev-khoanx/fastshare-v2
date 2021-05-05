<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
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
Route::post('/upload_file', 'HomeController@upload')->name('home.upload');
Route::get('/{path}', 'HomeController@download');
Route::post('/download', 'HomeController@downloadFile');
Route::post('/delete_file', 'HomeController@delete')->name('home.delete');
