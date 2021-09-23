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
//这里用用到了auth中间件，使用: 应该是传参数，我记得laravel使用中间件有很多种写法，可以看看文档

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
