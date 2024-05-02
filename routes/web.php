<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\GoogleMeetController;
use App\Http\Controllers\Auth\RegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Meeting resource routes
Route::resource('meetings', MeetingController::class);
// goggle authentication routes
Route::get('auth/google', [RegisterController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [RegisterController::class, 'handleGoogleCallback']);


