<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/accounts', [AccountController::class, 'create']);
Route::post('/accounts/{account}/deposit', [AccountController::class, 'deposit']);
Route::post('/accounts/{account}/withdraw', [AccountController::class, 'withdraw']);
Route::post('/accounts/{fromAccount}/transfer/{toAccount}', [AccountController::class, 'transfer']);