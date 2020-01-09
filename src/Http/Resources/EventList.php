<?php

namespace Innoflash\Events\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventList extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
