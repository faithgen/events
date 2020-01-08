<?php

namespace Innoflash\Events\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Innoflash\Events\Services\EventsService;

class EventController extends Controller
{
    protected $eventsService;

    public function __construct(EventsService $eventsService)
    {
        $this->eventsService = $eventsService;
    }
}
