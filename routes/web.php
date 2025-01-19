<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Broadcast;
use App\Http\Controllers\MessageController;
use App\Http\Middleware\CheckTeamSelected;

Route::post('/send-message', [MessageController::class, 'sendMessage']);
Route::post('/webhook', [MessageController::class, 'receiveMessage']);

Route::get('/', function () {
    return view('landing.landing');
});


Route::post('/send-audio', [AudioController::class, 'store']);


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    CheckTeamSelected::class,
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/teams/select', [TeamController::class, 'select'])->name('teams.select');



Route::post('/broadcast', function () {
    Broadcast::on('global')
        ->as('Message')
        ->with([
            'body' => str()->random(10)
        ])
        ->sendNow();
});

Route::get('/test', function(){

    return view('test');
});