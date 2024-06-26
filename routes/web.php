<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\v1\UrlController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('v1')
    ->group(static function() {
        Route::post('/encode', [UrlController::class, 'encode'])->name('encode');
        Route::post('/decode', [UrlController::class, 'decode'])->name('decode');
    });
