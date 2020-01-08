<?php

namespace Innoflash\Events\Models;

use FaithGen\SDK\Models\UuidModel;
use FaithGen\SDK\Traits\Relationships\Belongs\BelongsToMinistryTrait;

class Event extends UuidModel
{
    use BelongsToMinistryTrait;

    protected $casts = [
        'location' => 'array'
    ];

    function getNameAttribute($val)
    {
        return ucwords($val);
    }
}
