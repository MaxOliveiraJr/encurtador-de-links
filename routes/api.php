<?php

use App\Http\Controllers\LinkRedirectionController;
use App\Http\Controllers\LinkShortenerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('shortener', [LinkShortenerController::class, 'store']);
Route::get('/{code}',[LinkRedirectionController::class,'redirection']);
