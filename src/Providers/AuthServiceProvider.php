<?php

namespace Innoflash\Events\Providers;

use Innoflash\Events\Models\Event;
use Illuminate\Support\Facades\Gate;
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

        Gate::define('event.create', [EventPolicy::class, 'create']);
        //Gate::define('event.delete', [EventPolicy::class, 'delete']);
        Gate::define('event.view', [EventPolicy::class, 'view']);
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
