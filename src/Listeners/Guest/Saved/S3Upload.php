<?php

namespace Innoflash\Events\Listeners\Guest\Saved;

use Illuminate\Contracts\Queue\ShouldQueue;
use Innoflash\Events\Guest\Saved;

class S3Upload implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Saved  $event
     * @return void
     */
    public function handle(Saved $event)
    {
        //
    }
}
