<?php

use App\Http\Controllers\CardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/manage-cards', function () {
    return view('manage_cards');
});

Route::get('/topics', [CardController::class, 'getTopics']);
Route::post('/topics', [CardController::class, 'storeTopic']);
Route::delete('/topics/{id}', [CardController::class, 'destroyTopic']);

Route::get('/cards', [CardController::class, 'index']);
Route::get('/filter/{topic}', function ($topic) {
    return view('dashboard', ['topic' => $topic]);
});
Route::post('/cards', [CardController::class, 'store']);
Route::delete('/cards/{id}', [CardController::class, 'destroy']);
