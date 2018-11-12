<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome', [
        'url' => \Illuminate\Support\Facades\URL::route('test'),
        'signedUrl' => \Illuminate\Support\Facades\URL::signedRoute('signed'),
    ]);
});

Route::get('/test', function() {
    return response([
        'status' => 'ok',
        'url' => request()->fullUrl(),
    ]);
})->name('test');

Route::get('/signed', function() {
    return response([
        'status' => request()->hasValidSignature() ? 'ok' : 'failed',
        'url' => request()->fullUrl(),
    ]);
})->name('signed');