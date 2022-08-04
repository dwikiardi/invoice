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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::get('upgrade', function () {return view('pages.upgrade');})->name('upgrade');
	Route::get('map', function () {return view('pages.maps');})->name('map');
	Route::get('icons', function () {return view('pages.icons');})->name('icons');
	// Route::get('test', function () {return view('pages.print');})->name('test');
	Route::get('/datainvoice', ['as' => 'datainvoice', 'uses' => 'App\Http\Controllers\invoiceController@index']);
    Route::get('/datainvoice/list', ['as' => 'list.datainvoice', 'uses' => 'App\Http\Controllers\invoiceController@invoice']);
	Route::get('/list', ['as' => 'table', 'uses' => 'App\Http\Controllers\BarangController@index']);
    Route::get('/list/barang', ['as' => 'list.table', 'uses' => 'App\Http\Controllers\BarangController@listBarang']);
    Route::post('/list/delete', ['as' => 'delete.table', 'uses' => 'App\Http\Controllers\BarangController@deleteBarang']);
	Route::post('/list/addbarang', ['as' => 'add.table', 'uses' => 'App\Http\Controllers\BarangController@addBarang']);
    Route::post('/list/editbarang', ['as' => 'edit.table', 'uses' => 'App\Http\Controllers\BarangController@editBarang']);
	Route::post('/list/printInvoice', ['as' => 'add.table', 'uses' => 'App\Http\Controllers\BarangController@printInvoice']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
    Route::get('/print', ['as' => 'print', 'uses' => 'App\Http\Controllers\BarangController@printInvoice']);
});

