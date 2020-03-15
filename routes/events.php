<?php

use Illuminate\Support\Facades\Route;
use Innoflash\Events\Http\Controllers\EventController;

Route::prefix('events')->group(function () {
    Route::get('', [EventController::class, 'index']);
    Route::get('{event}', [EventController::class, 'view']);
    Route::get('comments/{event}', [EventController::class, 'comments']);
    Route::post('comment', [EventController::class, 'comment']);
});
