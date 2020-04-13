<?php

namespace Innoflash\Events\Jobs\Saved;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Innoflash\Events\Models\Event;
use Intervention\Image\ImageManager;

class UploadImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $deleteWhenMissingModels = true;
    protected $event;

    protected $image;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Event $event, string $image)
    {
        $this->event = $event;
        $this->image = $image;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(ImageManager $imageManager)
    {
        $fileName = str_shuffle($this->event->id.time().time()).'.png';
        $ogSave = storage_path('app/public/events/original/').$fileName;
        $imageManager->make($this->image)->save($ogSave);
        $this->event->image()->updateOrcreate([
            'imageable_id' => $this->event->id,
        ], [
            'name' => $fileName,
        ]);
    }
}
