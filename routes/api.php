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

Route::post('registration', [UserApiController::class, 'store']);
Route::post('login', [UserApiController::class, 'login']);
Route::post('forgot-password', [UserApiController::class, 'forgotPassword']);
// Route::get('show/{id}', [UserApiController::class, 'show']);

Route::get('golfer/{id}', [UserApiController::class, 'show']);
Route::get('golfer/{id}/scorecards', [UserApiController::class, 'posts']);
Route::get('golfer/{id}/comments', [UserApiController::class, 'comments']);

Route::get('categories', [CategoryApiController::class, 'index']);
Route::get('categories/{id}/posts', [CategoryApiController::class, 'posts']);

Route::get('scorecards', [ScorecardApiController::class, 'index']);
Route::get('scorecards/{id}', [ScorecardApiController::class, 'show']);
Route::get('scorecards/{id}/comments', [ScorecardApiController::class, 'comments']);

Route::get('tags/{id}/scorecards', [TagApiController::class, 'posts']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('comments/scorecards', [CommentApiController::class, 'store']);
    Route::post('logout', [UserApiController::class, 'logout']);
    Route::post('update-password',[UserApiController::class, 'updatePassword']);
});
