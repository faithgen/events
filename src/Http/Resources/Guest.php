<?php

namespace Innoflash\Events\Http\Resources;

use FaithGen\SDK\Helpers\ImageHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class Guest extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return array_merge(parent::toArray($request), [
            'avatar' => ImageHelper::getImage('events', $this->image, config('faithgen-sdk.ministries-server')),
        ]);
    }
}
