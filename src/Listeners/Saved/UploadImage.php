<?php

namespace Innoflash\Events\Listeners\Saved;

use Innoflash\Events\Saved;
use Intervention\Image\ImageManager;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UploadImage implements ShouldQueue
{
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
        $fileName = str_shuffle($event->getEvent()->id . time() . time()) . '.png';
        $ogSave = storage_path('app/public/events/original/') . $fileName;
        $this->imageManager->make($event->getImage())->save($ogSave);
        $event->getEvent()->image()->updateOrcreate([
            'imageable_id' => $event->getEvent()->id
        ], [
            'name' => $fileName
        ]);
    }
}
