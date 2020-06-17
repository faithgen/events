<?php

use Illuminate\Support\Facades\Route;
use Innoflash\Events\Http\Controllers\EventController;
use Innoflash\Events\Http\Controllers\GuestController;

Route::prefix('events')
    ->middleware('source.site')
    ->group(function () {
        Route::post('', [EventController::class, 'create']);
        Route::post('update/{event}', [EventController::class, 'update']);
        Route::put('toggle-publish/{event}', [EventController::class, 'togglePublish']);
        Route::delete('{event}', [EventController::class, 'destroy']);
        Route::delete('banner/{event}', [EventController::class, 'destroyBanner']);

        Route::post('add-guest', [GuestController::class, 'create']);
        Route::delete('guest/{guest}', [GuestController::class, 'destroy']);
    });
