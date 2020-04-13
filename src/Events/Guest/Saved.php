<?php

namespace Innoflash\Events\Events\Guest;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Innoflash\Events\Models\Guest;

class Saved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $guest;

    protected $image;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Guest $guest, $image)
    {
        $this->guest = $guest;
        $this->image = $image;
    }

    public function getGuest(): Guest
    {
        return $this->guest;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
