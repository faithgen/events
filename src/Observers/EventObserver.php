<?php

namespace Innoflash\Events\Observers;

use FaithGen\SDK\Traits\FileTraits;
use Innoflash\Events\Models\Event;
use Innoflash\Events\Saved;

class EventObserver
{
    use FileTraits;
    /**
     * Handle the event "created" event.
     *
     * @param  \App\Event  $event
     * @return void
     */
    public function created(Event $event)
    {
        if (request()->has('banner'))
            event(new Saved($event, request('banner')));
    }

    /**
     * Handle the event "updated" event.
     *
     * @param  \App\Event  $event
     * @return void
     */
    public function updated(Event $event)
    {
        if (request()->has('banner')) {
            $this->deleted($event);
            event(new Saved($event, request('banner')));
        }
    }

    /**
     * Handle the event "deleted" event.
     *
     * @param  \App\Event  $event
     * @return void
     */
    public function deleted(Event $event)
    {
        if ($event->image()->exists()) {
            $this->deleteFiles($event);
            $event->image()->delete();
        }
    }
}
