<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\api\PajakController;
use App\Http\Controllers\api\ItemController;
use App\Http\Controllers\api\ListDataItemController;

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

Route::get('/test', function () {
    return 'asdf';
});

Route::group(['prefix' => 'pajak'], function(){
    Route::get('', [PajakController::class, 'index']);
    Route::get('{id}', [PajakController::class, 'show']);
    Route::post('store', [PajakController::class, 'store']);
    Route::patch('update/{id}', [PajakController::class, 'update']);
    Route::get('delete/{id}', [PajakController::class, 'delete']);
});

Route::group(['prefix' => 'item'], function(){
    Route::get('', [ItemController::class, 'index']);
    Route::get('{id}', [ItemController::class, 'show']);
    Route::post('store', [ItemController::class, 'store']);
    Route::patch('update/{id}', [ItemController::class, 'update']);
    Route::get('delete/{id}', [ItemController::class, 'delete']);
});

Route::get('list-data-item', [ListDataItemController::class, 'listDataItem']);
