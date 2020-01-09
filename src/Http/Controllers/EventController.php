<?php

namespace Innoflash\Events\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Innoflash\Events\Http\Requests\CreateRequest;
use Innoflash\Events\Services\EventsService;
use Intervention\Image\Exception\NotFoundException;

class EventController extends Controller
{
    protected $eventsService;

    public function __construct(EventsService $eventsService)
    {
        $this->eventsService = $eventsService;
    }

    public function create(CreateRequest $request)
    {
        $params = $request->validated();
        if (!$request->has('location'))
            if (!auth()->user()->profile->location) throw new NotFoundException('No location found for this event!', 404);
            else $params['location'] = auth()->user()->profile->location;

        return $this->eventsService->createFromParent($params, 'Event created successfully');
    }
}
