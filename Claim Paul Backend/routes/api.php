<?php

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

Route::get('/search', [
    'as' => 'api.search',
    'uses' => 'Api\SearchController@search'
]);
Route::post('/login','App\Http\Controllers\loginController@login');
Route::post('/register','App\Http\Controllers\registerController@register');
Route::post('/logout','App\Http\Controllers\loginController@logout');
