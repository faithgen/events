<?php

namespace Innoflash\Events\Listeners\Saved;

use Innoflash\Events\Saved;
use Intervention\Image\ImageManager;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessImage implements ShouldQueue
{
    /**
     * @var ImageManager
     */
    private $imageManager;

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
        if ($event->getEvent()->image()->exists()) {
            $ogImage = storage_path('app/public/events/original/') . $event->getEvent()->image->name;
            $thumb100 = storage_path('app/public/events/50-50/') . $event->getEvent()->image->name;

            $this->imageManager->make($ogImage)->fit(50, 50, function ($constraint) {
                $constraint->upsize();
                $constraint->aspectRatio();
            }, 'center')->save($thumb100);
        }
    }
}
