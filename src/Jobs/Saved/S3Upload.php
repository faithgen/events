<?php

namespace Innoflash\Events\Jobs\Saved;

use FaithGen\SDK\Traits\SavesToAmazonS3;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Innoflash\Events\Models\Event;

class S3Upload implements ShouldQueue
{
    use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels,
        SavesToAmazonS3;

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
    public function handle()
    {
        try {
            $this->saveFiles($this->event);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
