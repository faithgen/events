<?php

namespace Innoflash\Events;

use FaithGen\SDK\Traits\ConfigTrait;
use Illuminate\Support\ServiceProvider;
use Innoflash\Events\Models\Event;
use Innoflash\Events\Models\Guest;
use Innoflash\Events\Observers\EventObserver;
use Innoflash\Events\Observers\GuestObserver;
use Innoflash\Events\Services\EventsService;
use Innoflash\Events\Services\GuestService;

class EventsServiceProvider extends ServiceProvider
{
    use ConfigTrait;
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerRoutes(__DIR__ . '/routes/events.php', __DIR__ . '/routes/source.php');

        $this->setUpSourceFiles(function () {
            $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

            $this->publishes([
                __DIR__ . '/../database/migrations/' => database_path('migrations'),
            ], 'faithgen-events-migrations');

            $this->publishes([
                __DIR__ . '/storage/events/' => storage_path('app/public/events')
            ], 'faithgen-events-storage');
        });

        $this->publishes([
            __DIR__ . '/../config/faithgen-events.php' => config_path('faithgen-events.php'),
        ], 'faithgen-events-config');

        Event::observe(EventObserver::class);
        Guest::observe(GuestObserver::class);
    }

    /**
     * Get the Blogg route group configuration array.
     *
     * @return array
     */
    private function routeConfiguration()
    {
        return [
            'prefix' => config('faithgen-events.prefix'),
            'namespace' => "FaithGen\Events\Http\Controllers",
            'middleware' => config('faithgen-events.middlewares'),
        ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/faithgen-events.php', 'faithgen-events');

        $this->app->singleton(EventsService::class);
        $this->app->singleton(GuestService::class);
    }
}
