<?php

namespace Innoflash\Events\Models;

use FaithGen\SDK\Models\UuidModel;
use FaithGen\SDK\Traits\Relationships\Morphs\ImageableTrait;
use FaithGen\SDK\Traits\StorageTrait;
use Illuminate\Support\Str;

class Guest extends UuidModel
{
    use ImageableTrait, StorageTrait;

    protected $guarded = ['id'];

    protected $hidden = [
        'created_at',
        'updated_at',
        'event_id',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function getTitleAttribute($val)
    {
        return Str::title($val);
    }

    public function getNameAttribute($val)
    {
        return Str::title($val);
    }

    public function getFileName()
    {
        return $this->image->name;
    }

    public function filesDir()
    {
        return 'events';
    }

    public function getImageDimensions()
    {
        return [
            0, 50,
        ];
    }
}
