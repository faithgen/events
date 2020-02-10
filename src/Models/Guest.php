<?php

namespace Innoflash\Events\Models;

use Illuminate\Support\Str;
use FaithGen\SDK\Models\UuidModel;
use FaithGen\SDK\Traits\Relationships\Morphs\ImageableTrait;
use FaithGen\SDK\Traits\StorageTrait;

class Guest extends UuidModel
{
    use ImageableTrait, StorageTrait;

    protected $guarded = ['id'];


    function event()
    {
        return $this->belongsTo(Event::class);
    }

    function getTitleAttribute($val)
    {
        return Str::title($val);
    }

    function getNameAttribute($val)
    {
        return Str::title($val);
    }

    function getFileName(string $path)
    {
        return $this->image->name;
    }

    function filesDir()
    {
        return 'events';
    }

    function getImageDimensions()
    {
        return [
            0, 50
        ];
    }
}
