<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Smile Score Landing Page and initial routes.
|
*/

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/smile-score', function () {
    return view('smile-score-placeholder');
})->name('smile-score.start');
