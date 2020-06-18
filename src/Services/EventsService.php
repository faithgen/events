<?php

namespace Innoflash\Events\Services;

use FaithGen\SDK\Traits\FileTraits;
use Innoflash\Events\Models\Event;
use InnoFlash\LaraStart\Services\CRUDServices;

class EventsService extends CRUDServices
{
    use FileTraits;

    protected Event $event;

    public function __construct()
    {
        $this->event = app(Event::class);

        $eventId = request()->route('event') ?? request('event_id');

        if($eventId){
            $this->event = $this->event->resolveRouteBinding($eventId);
        }
    }

    /**
     * Retrieves an instance of event.
     *
     * @return \Innoflash\Events\Models\Event
     */
    public function getEvent(): Event
    {
        return $this->event;
    }

    /**
     * Makes a list of fields that you do not want to be sent
     * to the create or update methods.
     * Its mainly the fields that you do not have in the messages table.
     *
     * @return array
     */
    public function getUnsetFields(): array
    {
        return ['event_id', 'banner'];
    }

    /**
     * Attaches a parent to the current event
     * You can delete this if you do not intent to create events from parent relationships.
     */
    public function getParentRelationship()
    {
        return auth()->user()->events();
    }

    public function deleteBanner($event)
    {
        if ($event->image()->exists()) {
            $this->deleteFiles($event);
            $event->image()->delete();

            return $this->successResponse('Banner deleted');
        }

        return $this->successResponse('This event doesn`t have a banner already');
    }
}
