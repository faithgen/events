<?php

namespace Innoflash\Events\Services;

use Innoflash\Events\Models\Event;
use Innoflash\Events\Models\Guest;
use InnoFlash\LaraStart\Services\CRUDServices;

class GuestService extends CRUDServices
{
    protected Guest $guest;

    public function __construct()
    {
        $this->guest = app(Guest::class);

        $guestId = request()->route('guest') ?? request('guest_id');

        if ($guestId) {
            $this->guest = $this->guest->resolveRouteBinding($guestId);
        }
    }

    /**
     * Retrieves an instance of guest.
     *
     * @return \Innoflash\Events\Models\Guest
     */
    public function getGuest(): Guest
    {
        return $this->guest;
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
        return ['guest_id', 'image'];
    }

    /**
     * Attaches a parent to the current guest
     * You can delete this if you do not intent to create guests from parent relationships.
     */
    public function getParentRelationship()
    {
        return [
            Event::class,
            'guests',
        ];
    }
}
