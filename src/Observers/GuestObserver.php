<?php

namespace Innoflash\Events\Observers;

use FaithGen\SDK\Traits\FileTraits;
use Innoflash\Events\Models\Guest;

class GuestObserver
{
    use FileTraits;

    function deleted(Guest $guest)
    {
        if ($guest->image()->exists()) {
            $this->deleteFiles($guest);
            $guest->image()->delete();
        }
    }
    function created(Guest $guest)
    {
    }

    function updated(Guest $guest)
    {
    }
}
