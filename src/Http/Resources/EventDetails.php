<?php

namespace Innoflash\Events\Http\Resources;

use Carbon\Carbon;
use FaithGen\SDK\SDK;
use InnoFlash\LaraStart\Http\Helper;
use Illuminate\Http\Resources\Json\JsonResource;

class EventDetails extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'location' => $this->location,
            'description' => $this->description,
            'url' => $this->url,
            'video_url' => $this->video_url,
            'start' => Helper::getDates($this->start),
            'end' => Helper::getDates($this->end),
            'is_past' => Carbon::parse($this->end)->isPast(),
            'date' => Carbon::parse($this->start)->format('Y/m/d'),
            'avatar' => $this->image()->exists() ? $this->getAvatar($this) : null,
            'guests' => Guest::collection($this->guests)
        ];
    }

    function getAvatar($event)
    {
        return [
            '_50' => SDK::getAsset('storage/events/50-50/' . $event->image->name),
            'original' => SDK::getAsset('storage/events/original/' . $event->image->name),
        ];
    }
}
