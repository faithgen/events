<?php

namespace Innoflash\Events\Policies;

use App\Models\Ministry;
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
    public function view(Ministry $ministry, Event $event)
    {
        //
    }

    /**
     * Determine whether the ministry can create events.
     *
     * @param  \  $ministry
     * @return mixed
     */
    public function create(Ministry $ministry)
    {
        //
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
        //
    }

    /**
     * Determine whether the ministry can delete the event.
     *
     * @param  \  $ministry
     * @param  \Innoflash\Events\Models\Event  $event
     * @return mixed
     */
    public function delete(Ministry $ministry, Event $event)
    {
        //
    }

    /**
     * Determine whether the ministry can restore the event.
     *
     * @param  \  $ministry
     * @param  \Innoflash\Events\Models\Event  $event
     * @return mixed
     */
    public function restore(Ministry $ministry, Event $event)
    {
        //
    }

    /**
     * Determine whether the ministry can permanently delete the event.
     *
     * @param  \  $ministry
     * @param  \Innoflash\Events\Models\Event  $event
     * @return mixed
     */
    public function forceDelete(Ministry $ministry, Event $event)
    {
        //
    }
}
