<?php

namespace Innoflash\Events\Services;

use FaithGen\SDK\Traits\FileTraits;
use Innoflash\Events\Models\Event;
use InnoFlash\LaraStart\Services\CRUDServices;

class EventsService extends CRUDServices
{
    use FileTraits;

    private $event;

    public function __construct(Event $event)
    {
        if (request()->has('event_id')) {
            $this->event = Event::findOrFail(request('event_id'));
        } else {
            $this->event = $event;
        }
    }

    /**
     * Retrives an instance of event.
     */
    public function getEvent(): Event
    {
        return $this->event;
    }

    /**
     * Makes a list of fields that you do not want to be sent
     * to the create or update methods
     * Its mainly the fields that you do not have in the events table.
     */
    public function getUnsetFields()
    {
        return ['event_id', 'banner'];
    }

    /**
     * This returns the model found in the constructor
     * or an instance of the class if no event is found.
     */
    public function getModel()
    {
        return $this->getEvent();
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
        } else {
            return $this->successResponse('This event doesn`t have a banner already');
        }

        return abort(500, 'Error on deleting the banner');
    }
}
