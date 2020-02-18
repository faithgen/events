<?php

namespace Innoflash\Events\Policies;

use App\Models\Ministry;
use Illuminate\Auth\Access\AuthorizationException;
use Innoflash\Events\Models\Event;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the ministry can view the event.
     *
     * @param  \  $ministry
     * @param  \Innoflash\Events\Models\Event  $event
     * @return mixed
     */
    public static function view(Ministry $ministry, Event $event)
    {
        return $ministry->id === $event->ministry_id;
    }

    /**
     * Determine whether the ministry can create events.
     *
     * @param  \  $ministry
     * @return mixed
     */
    public static function create(Ministry $ministry)
    {
        if ($ministry->account->level === 'Free') return false;
        if ($ministry->events()->where(request()->only(['name', 'start', 'end']))->count())
            abort(403, 'You already registered this event');
        else return true;
    }

    /**
     * Determine whether the ministry can update the event.
     *
     * @param  \  $ministry
     * @param  \Innoflash\Events\Models\Event  $event
     * @return mixed
     */
    public function update(Ministry $ministry, Event $event)
    {
        return $ministry->id === $event->ministry_id;
    }

    /**
     * Determine whether the ministry can delete the event.
     *
     * @param  \  $ministry
     * @param  \Innoflash\Events\Models\Event  $event
     * @return mixed
     */
    public static function delete(Ministry $ministry, Event $event)
    {
        return $ministry->id === $event->ministry_id;
    }
}
