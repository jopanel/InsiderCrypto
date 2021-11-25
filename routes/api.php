<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Control;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/asyncPriceRequest', 'App\Http\Controllers\Api@asyncPriceRequest');
Route::get('/update', 'App\Http\Controllers\Api@updateMatches');
Route::get('/maintenance', 'App\Http\Controllers\Api@maintenance');
Route::get('/getpricedata', 'App\Http\Controllers\Api@getAllPriceData');
Route::get('/testmatchdata', 'App\Http\Controllers\Api@testmatchdata');