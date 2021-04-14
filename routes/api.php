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

Route::post('upload-file', [\App\Http\Controllers\Api\ImportFileController::class, 'uploadFile']);
Route::get('get-file-content', [\App\Http\Controllers\Api\ImportFileController::class, 'getFileContent']);
Route::post('store-file-content', [\App\Http\Controllers\Api\ImportFileController::class, 'storeFileContent']);
Route::get('get-file-list', [\App\Http\Controllers\Api\ImportFileController::class, 'getFileList']);
Route::get('get-file-items', [\App\Http\Controllers\Api\FileContentController::class, 'getFileItems']);
Route::get('download-file', [\App\Http\Controllers\Api\FileContentController::class, 'downLoadFile']);
Route::delete('remove-file-item', [\App\Http\Controllers\Api\FileContentController::class, 'removeFileItem']);
Route::post('add-file-item', [\App\Http\Controllers\Api\FileContentController::class, 'addFileItem']);
Route::patch('update-file-item', [\App\Http\Controllers\Api\FileContentController::class, 'updateFileItem']);
