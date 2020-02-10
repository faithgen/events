<?php

namespace Innoflash\Events\Observers;

use Innoflash\Events\Guest\Saved;
use Innoflash\Events\Models\Guest;
use FaithGen\SDK\Traits\FileTraits;

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
        event(new Saved($guest, request('image')));
    }

    function updated(Guest $guest)
    {
    }
}
