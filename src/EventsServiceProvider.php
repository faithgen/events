<?php

namespace Innoflash\Events;

use FaithGen\SDK\Traits\ConfigTrait;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Innoflash\Events\Services\EventsService;

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
        $this->mergeConfigFrom(__DIR__ . '/../config/faithgen-events.php', 'faithgen-events');

        $this->registerRoutes(__DIR__ . '/routes/events.php', __DIR__ . '/routes/source.php');

        $this->setUpSourceFiles(function () {
            $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

            $this->publishes([
                __DIR__ . '/database/migrations/' => database_path('migrations'),
            ], 'faithgen-events-migrations');
        });

        $this->publishes([
            __DIR__ . '/../config/faithgen-events.php' => config_path('faithgen-events.php'),
        ], 'faithgen-events-config');

        $this->app->singleton(EventsService::class, EventsService::class);
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
        // Register facade
        // $this->app->singleton('events', function () {
        //     return new EventsFacade();
        //  });
    }
}
