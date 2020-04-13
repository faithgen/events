<?php

namespace Innoflash\Events\Http\Resources;

use Carbon\Carbon;
use FaithGen\SDK\Helpers\ImageHelper;
use Illuminate\Http\Resources\Json\JsonResource;
use InnoFlash\LaraStart\Helper;

class Event extends JsonResource
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
            'published' => $this->published,
            'location' => $this->location,
            'description' => $this->description,
            'start' => Helper::getDates($this->start),
            'end' => Helper::getDates($this->end),
            'is_past' => Carbon::parse($this->end)->isPast(),
            'avatar' => ImageHelper::getImage('events', $this->image, config('faithgen-sdk.ministries-server')),
            'date' => Carbon::parse($this->start)->format('Y/m/d'),
        ];
    }
}
