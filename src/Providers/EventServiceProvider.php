<?php

namespace Innoflash\Events\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        \Innoflash\Events\Saved::class => [
            \Innoflash\Events\Listeners\Saved\UploadImage::class,
            \Innoflash\Events\Listeners\Saved\ProcessImage::class,
            \Innoflash\Events\Listeners\Saved\S3Upload::class,
        ],
    ];
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
