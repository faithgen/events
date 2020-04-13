<?php

namespace Innoflash\Events\Http\Controllers;

use Carbon\Carbon;
use FaithGen\SDK\Helpers\CommentHelper;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Innoflash\Events\Http\Requests\CommentRequest;
use Innoflash\Events\Http\Requests\CreateRequest;
use Innoflash\Events\Http\Requests\DeleteRequest;
use Innoflash\Events\Http\Requests\TogglePublishRequest;
use Innoflash\Events\Http\Requests\UpdateRequest;
use Innoflash\Events\Http\Resources\Event as EventResource;
use Innoflash\Events\Http\Resources\EventDetails;
use Innoflash\Events\Models\Event;
use Innoflash\Events\Services\EventsService;
use Intervention\Image\Exception\NotFoundException;

class EventController extends Controller
{
    use AuthorizesRequests;

    protected $eventsService;

    public function __construct(EventsService $eventsService)
    {
        $this->eventsService = $eventsService;
    }

    /**
     * Creates and event.
     *
     * @param CreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateRequest $request)
    {
        $params = $request->validated();
        if (! $request->has('location')) {
            if (! auth()->user()->profile->location) {
                throw new NotFoundException('No location found for this event, set one or set your profile location!', 404);
            } else {
                $params['location'] = auth()->user()->profile->location;
            }
        }

        return $this->eventsService->createFromParent($params, 'Event created successfully');
    }

    /**
     * Fetches the events for the given date.
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        if ($request->has('date')) {
            $date = Carbon::parse($request->date);
        } else {
            $date = Carbon::now();
        }

        $events = auth()->user()->events()
            ->whereDate('start', '>=', $date->startOfMonth())
            ->whereDate('end', '<=', $date->endOfMonth())
            ->published()
            ->orderBy('start', 'asc')
            ->get();

        EventResource::wrap('events');

        return EventResource::collection($events);
    }

    /**
     * Updates an event.
     *
     * @param UpdateRequest $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function update(UpdateRequest $request)
    {
        return $this->eventsService->update($request->validated(), 'Event updated successfully!');
    }

    /**
     * Toggles ublish status.
     *
     * @param TogglePublishRequest $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function togglePublish(TogglePublishRequest $request)
    {
        return $this->eventsService->update($request->validated(), 'Event publish status changed successfully!');
    }

    /**
     * Deletes event.
     *
     * @param DeleteRequest $request
     * @return mixed
     */
    public function destroy(DeleteRequest $request)
    {
        return $this->eventsService->destroy('Event deleted successfully!');
    }

    /**
     * Views the singular event.
     *
     * @param Event $event
     * @return EventDetails
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function view(Event $event)
    {
        $this->authorize('view', $event);
        EventDetails::withoutWrapping();

        return new EventDetails($event);
    }

    /**
     * Gets the comments for the event.
     *
     * @param Request $request
     * @param Event $event
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function comments(Request $request, Event $event)
    {
        $this->authorize('view', $event);

        return CommentHelper::getComments($event, $request);
    }

    /**
     * Sends a comment to an event.
     *
     * @param CommentRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function comment(CommentRequest $request)
    {
        if (Carbon::parse($this->eventsService->getEvent()->end)->isPast()) {
            abort(400, 'This event is over, you can`t send anymore comments');
        }

        return CommentHelper::createComment($this->eventsService->getEvent(), $request);
    }

    /**
     * Deletes the banner for an event.
     *
     * @param Event $event
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroyBanner(Event $event)
    {
        $this->authorize('view', $event);

        return $this->eventsService->deleteBanner($event);
    }
}
