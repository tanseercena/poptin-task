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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'rules', 'middleware' => ['auth:api']], function () {
    Route::get("/", [\App\Http\Controllers\RuleController::class, 'index']);
    Route::post("/", [\App\Http\Controllers\RuleController::class, 'save']);
    Route::delete("/{rule}", [\App\Http\Controllers\RuleController::class, 'delete']);
});

Route::get("check-rule-conditions/{rule}", [\App\Http\Controllers\RuleController::class, 'checkRuleCondition']);
