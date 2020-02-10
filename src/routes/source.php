<?php

use Illuminate\Support\Facades\Route;
use Innoflash\Events\Http\Controllers\EventController;
use Innoflash\Events\Http\Controllers\GuestController;

Route::prefix('events')
    ->middleware('source.site')
    ->group(function () {
        Route::post('', [EventController::class, 'create']);
        Route::post('update', [EventController::class, 'update']);
        Route::post('toggle-publish', [EventController::class, 'togglePublish']);
        Route::delete('', [EventController::class, 'destroy']);
        Route::delete('banner/{event}', [EventController::class, 'destroyBanner']);

        Route::post('add-guest', [GuestController::class, 'create']);
    });
