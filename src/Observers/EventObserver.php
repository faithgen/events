<?php

namespace Innoflash\Events\Observers;

use FaithGen\SDK\Traits\FileTraits;
use Innoflash\Events\Jobs\Saved\ProcessImage;
use Innoflash\Events\Jobs\Saved\S3Upload;
use Innoflash\Events\Jobs\Saved\UploadImage;
use Innoflash\Events\Models\Event;

class EventObserver
{
    use FileTraits;
    /**
     * Handle the event "created" event.
     *
     * @param  \App\Event  $event
     * @return void
     */
    public function created(Event $event)
    {
        if (request()->has('banner'))
            UploadImage::withChain([
                new ProcessImage($event),
                new S3Upload($event)
            ])
            ->dispatch($event, request('banner'));
    }

    /**
     * Handle the event "updated" event.
     *
     * @param  \App\Event  $event
     * @return void
     */
    public function updated(Event $event)
    {
        if (request()->has('banner')) {
            $this->deleted($event);
            UploadImage::withChain([
                new ProcessImage($event),
                new S3Upload($event)
            ])
            ->dispatch($event, request('banner'));
        }
    }

    /**
     * Handle the event "deleted" event.
     *
     * @param  \App\Event  $event
     * @return void
     */
    public function deleted(Event $event)
    {
        if ($event->image()->exists()) {
            $this->deleteFiles($event);
            $event->image()->delete();
        }
    }
}
