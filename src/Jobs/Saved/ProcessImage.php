<?php

namespace Innoflash\Events\Jobs\Saved;

use Illuminate\Bus\Queueable;
use Innoflash\Events\Models\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Intervention\Image\ImageManager;

class ProcessImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $deleteWhenMissingModels = true;
    protected $event;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(ImageManager $imageManager)
    {
        if ($this->event->image()->exists()) {
            $ogImage = storage_path('app/public/events/original/') . $this->event->image->name;
            $thumb100 = storage_path('app/public/events/50-50/') . $this->event->image->name;

            $imageManager->make($ogImage)->fit(50, 50, function ($constraint) {
                $constraint->upsize();
                $constraint->aspectRatio();
            }, 'center')->save($thumb100);
        }
    }
}
