<?php

namespace Innoflash\Events\Listeners\Saved;

use Innoflash\Events\Saved;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class S3Upload
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
