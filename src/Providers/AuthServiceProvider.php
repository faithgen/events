<?php

namespace Innoflash\Events\Providers;

use Innoflash\Events\Models\Event;
use Innoflash\Events\Policies\EventPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Event::class => EventPolicy::class
    ];
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
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
