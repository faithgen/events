<?php

namespace Innoflash\Events;

use Innoflash\Events\Models\Event;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Saved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $event;
    private $image;

    public function __construct(Event $event, $image)
    {
        $this->event = $event;
        $this->image = $image;
    }

    function getEvent(): Event
    {
        return $this->event;
    }

    function getImage(): string
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
