<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Broadcast;
use App\Http\Controllers\MessageController;

Route::post('/send-message', [MessageController::class, 'sendMessage']);
Route::post('/webhook', [MessageController::class, 'receiveMessage']);

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::post('/broadcast', function () {
    Broadcast::on('global')
        ->as('Message')
        ->with([
            'body' => str()->random(10)
        ])
        ->sendNow();
});

