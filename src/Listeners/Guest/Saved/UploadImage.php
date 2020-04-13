<?php

namespace Innoflash\Events\Listeners\Guest\Saved;

use Illuminate\Contracts\Queue\ShouldQueue;
use Innoflash\Events\Guest\Saved;
use Intervention\Image\ImageManager;

class UploadImage implements ShouldQueue
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
        $fileName = 'guest-'.str_shuffle($event->getGuest()->id.time().time()).'.png';
        $ogSave = storage_path('app/public/events/original/').$fileName;
        $this->imageManager->make($event->getImage())->save($ogSave);
        $event->getGuest()->image()->updateOrcreate([
            'imageable_id' => $event->getGuest()->id,
        ], [
            'name' => $fileName,
        ]);
    }
}
