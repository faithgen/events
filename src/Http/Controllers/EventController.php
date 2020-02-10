<?php

namespace Innoflash\Events\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Innoflash\Events\Models\Event;
use App\Http\Controllers\Controller;
use FaithGen\SDK\Helpers\CommentHelper;
use Innoflash\Events\Services\EventsService;
use Innoflash\Events\Http\Requests\CreateRequest;
use Innoflash\Events\Http\Requests\DeleteRequest;
use Innoflash\Events\Http\Requests\UpdateRequest;
use Innoflash\Events\Http\Requests\CommentRequest;
use Intervention\Image\Exception\NotFoundException;
use Innoflash\Events\Http\Requests\TogglePublishRequest;
use Innoflash\Events\Http\Resources\Event as EventResource;
use Innoflash\Events\Http\Resources\EventDetails;

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

    public function index(Request $request)
    {
        if ($request->has('date')) $date = Carbon::parse($request->date);
        else $date = Carbon::now();

        $events = auth()->user()->events()
            ->whereDate('start', '>=', $date->startOfMonth())
            ->whereDate('end', '<=', $date->endOfMonth())
            ->published()
            ->orderBy('start', 'asc')
            ->get();
        return EventResource::collection($events);
    }

    public function update(UpdateRequest $request)
    {
        return $this->eventsService->update($request->validated(), 'Event updated successfully!');
    }

    public function togglePublish(TogglePublishRequest $request)
    {
        return $this->eventsService->update($request->validated(), 'Event publish status changed successfully!');
    }

    public function destroy(DeleteRequest $request)
    {
        return $this->eventsService->destroy('Event deleted successfully!');
    }

    public function view(Event $event)
    {
        $this->authorize('event.view', $event);
        EventDetails::withoutWrapping();
        return new EventDetails($event);
    }

    public function comments(Request $request, Event $event)
    {
        $this->authorize('event.view', $event);
        return CommentHelper::getComments($event, $request);
    }

    public function comment(CommentRequest $request)
    {
        if (Carbon::parse($this->eventsService->getEvent()->end)->isPast())
            abort(400, 'This event is over, you can`t send anymore comments');
        return CommentHelper::createComment($this->eventsService->getEvent(), $request);
    }

    public function destroyBanner(Event $event)
    {
        $this->authorize('event.view', $event);
        return $this->eventsService->deleteBanner($event);
    }
}
