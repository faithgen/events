<?php

namespace Innoflash\Events\Http\Resources;

use FaithGen\SDK\SDK;
use Illuminate\Http\Resources\Json\JsonResource;

class Guest extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return array_merge(parent::toArray($request), [
            'avatar' => [
                '_50' => SDK::getAsset('storage/events/50-50/' . $this->image->name),
                'original' => SDK::getAsset('storage/events/original/' . $this->image->name),
            ]
        ]);
    }
}
