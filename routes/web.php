<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Control;

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


// viewable routes

Route::get('/', 'App\Http\Controllers\Control@index');

Route::get('/access/login', 'App\Http\Controllers\Access@login');
Route::post('/access/login', 'App\Http\Controllers\Access@login');

Route::get('/access/register', 'App\Http\Controllers\Access@register');
Route::post('/access/register', 'App\Http\Controllers\Access@register');

Route::get('/access/forgot', 'App\Http\Controllers\Access@forgot');

Route::get('/control/preferences', 'App\Http\Controllers\Control@preferences');
Route::post('/control/preferences', 'App\Http\Controllers\Control@preferences');

Route::get('/control/account', 'App\Http\Controllers\Control@account');
Route::post('/control/account', 'App\Http\Controllers\Control@account');


Route::get('/docs/privacy', 'App\Http\Controllers\Docs@privacy');
Route::get('/docs/terms', 'App\Http\Controllers\Docs@terms');
Route::get('/docs/faq', 'App\Http\Controllers\Docs@faq');


