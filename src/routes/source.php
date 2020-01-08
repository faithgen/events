<?php

use Illuminate\Support\Facades\Route;

Route::prefix('events')
    ->middleware('source.site')
    ->group(function () {
    });
