<?php

namespace Innoflash\Events\Services;

use Innoflash\Events\Models\Guest;
use InnoFlash\LaraStart\Services\CRUDServices;
use Illuminate\Database\Eloquent\Model as ParentModel;
use Innoflash\Events\Models\Event;

class GuestService extends CRUDServices
{
    private $guest;
    function __construct(Guest $guest)
    {
        if (request()->has('guest_id'))
            $this->guest = Guest::findOrFail(request('guest_id'));
        else $this->guest = $guest;
    }

    /**
     * Retrives an instance of guest
     */
    public function getGuest(): Guest
    {
        return $this->guest;
    }

    /**
     * Makes a list of fields that you do not want to be sent
     * to the create or update methods
     * Its mainly the fields that you do not have in the guests table
     */
    function getUnsetFields()
    {
        return ['guest_id', 'image'];
    }

    /**
     * This returns the model found in the constructor 
     * or an instance of the class if no guest is found
     */
    function getModel()
    {
        return $this->getGuest();
    }


    /**
     * Attaches a parent to the current guest
     * You can delete this if you do not intent to create guests from parent relationships
     */
    function getParentRelationship()
    {
        return [
            Event::class,
            'guests',
        ];
    }
}
