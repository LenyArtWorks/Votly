<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Polls;
use App\Http\Controllers\Auth;
use App\Http\Controllers\User;
use App\Http\Controllers\Auth\GoogleController;

Route::get('/', [Polls::class, 'latestPolls']);

Route::group(['prefix' => 'auth'], function() {
    Route::get('/google', [GoogleController::class, 'redirectToGoogle']);
    Route::get('/google/callback', [GoogleController::class, 'handleGoogleCallback']);
    Route::inertia('/register', 'Register')->name('register');
    Route::inertia('/login', 'Login');
    Route::post('/register', [Auth::class, 'register']);
    Route::post('/login', [Auth::class, 'login'])->name('login');
    Route::get('/logout', [Auth::class, 'logout']);
});

Route::group(['prefix' => 'polls'], function() {
    Route::get('/', [Polls::class, 'get'])->name('polls');
    Route::post('/add', [Polls::class, 'add']);
    Route::get('/create', [Polls::class, 'createPoll'])->middleware('auth');
    Route::get('/user', [Polls::class, 'getUserPolls']);
    Route::get('/result', [Polls::class, 'pollResult']);
    Route::get('/history', [Polls::class, 'history']);
    Route::post('/delete', [Polls::class, 'deletePoll']);
    Route::post('/vote', [Polls::class, 'vote']);
});

Route::group(['prefix' => 'user'], function() {
    Route::get('/votes', [Polls::class, 'getVotes']);
    Route::get('/profile', [User::class, 'getUser'])->middleware('auth');
    Route::get('/polls', [Polls::class, 'getUserPolls']);
    Route::post('/check-password', [User::class, 'checkPassword']);

    Route::group(['prefix' => 'update'], function() {
        Route::post('/password', [User::class, 'updatePassword']);
        Route::post('/login', [User::class, 'updateLogin']);
        Route::post('/email', [User::class, 'updateEmail']);
        Route::post('/birthdate', [User::class, 'updateBirthDate']);
        Route::post('/gender', [User::class, 'updateGender']);
    });
});
