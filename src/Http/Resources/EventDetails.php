<?php

namespace Innoflash\Events\Http\Resources;

use Carbon\Carbon;
use FaithGen\SDK\Helpers\ImageHelper;
use Illuminate\Http\Resources\Json\JsonResource;
use InnoFlash\LaraStart\Helper;

class EventDetails extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'location' => $this->location,
            'published' => $this->published,
            'description' => $this->description,
            'url' => $this->url,
            'video_url' => $this->video_url,
            'start' => Helper::getDates($this->start),
            'end' => Helper::getDates($this->end),
            'is_past' => Carbon::parse($this->end)->isPast(),
            'date' => Carbon::parse($this->start)->format('Y/m/d'),
            'avatar' => ImageHelper::getImage('events', $this->image, config('faithgen-sdk.ministries-server')),
            'guests' => Guest::collection($this->guests)
        ];
    }
}
