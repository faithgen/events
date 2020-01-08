<?php

namespace Innoflash\Events;

use Illuminate\Support\Facades\Facade;

class EventsFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'events';
    }
}