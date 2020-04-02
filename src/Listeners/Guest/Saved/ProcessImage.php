<?php

namespace Innoflash\Events\Listeners\Guest\Saved;

use Innoflash\Events\Events\Guest\Saved;
use Intervention\Image\ImageManager;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessImage implements ShouldQueue
{
    protected $imageManager;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(ImageManager $imageManager)
    {
        $this->imageManager = $imageManager;
    }

    /**
     * Handle the event.
     *
     * @param  Saved  $event
     * @return void
     */
    public function handle(Saved $event)
    {
        if ($event->getGuest()->image()->exists()) {
            $ogImage = storage_path('app/public/events/original/') . $event->getGuest()->image->name;
            $thumb100 = storage_path('app/public/events/50-50/') . $event->getGuest()->image->name;

            $this->imageManager->make($ogImage)->fit(50, 50, function ($constraint) {
                $constraint->upsize();
                $constraint->aspectRatio();
            }, 'center')->save($thumb100);
        }
    }
}
