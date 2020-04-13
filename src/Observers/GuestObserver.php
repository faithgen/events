<?php

namespace Innoflash\Events\Observers;

use FaithGen\SDK\Traits\FileTraits;
use Innoflash\Events\Guest\Saved;
use Innoflash\Events\Models\Guest;

class GuestObserver
{
    use FileTraits;

    public function deleted(Guest $guest)
    {
        if ($guest->image()->exists()) {
            $this->deleteFiles($guest);
            $guest->image()->delete();
        }
    }

    public function created(Guest $guest)
    {
        event(new Saved($guest, request('image')));
    }

    public function updated(Guest $guest)
    {
    }
}
