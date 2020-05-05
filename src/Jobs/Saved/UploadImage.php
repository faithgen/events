<?php

namespace Innoflash\Events\Jobs\Saved;

use FaithGen\SDK\Traits\UploadsImages;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Innoflash\Events\Models\Event;
use Intervention\Image\ImageManager;

class UploadImage implements ShouldQueue
{
    use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels,
        UploadsImages;

    public bool $deleteWhenMissingModels = true;
    protected Event $event;

    protected string $image;

    /**
     * Create a new job instance.
     *
     * @param Event $event
     * @param string $image
     */
    public function __construct(Event $event, string $image)
    {
        $this->event = $event;
        $this->image = $image;
    }

    /**
     * Execute the job.
     *
     * @param ImageManager $imageManager
     *
     * @return void
     */
    public function handle(ImageManager $imageManager)
    {
        $this->uploadImages($this->event, [$this->image], $imageManager);
    }
}
