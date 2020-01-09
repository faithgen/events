<?php

use Illuminate\Support\Facades\Route;
use Innoflash\Events\Http\Controllers\EventController;

Route::prefix('events')
    ->middleware('source.site')
    ->group(function () {
        Route::post('', [EventController::class, 'create']);
    });
