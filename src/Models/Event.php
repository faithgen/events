<?php

namespace Innoflash\Events\Models;

use FaithGen\SDK\SDK;
use FaithGen\SDK\Models\UuidModel;
use FaithGen\SDK\Traits\StorageTrait;
use FaithGen\SDK\Traits\Relationships\Morphs\ImageableTrait;
use FaithGen\SDK\Traits\Relationships\Morphs\CommentableTrait;
use FaithGen\SDK\Traits\Relationships\Belongs\BelongsToMinistryTrait;

class Event extends UuidModel
{
    use BelongsToMinistryTrait, CommentableTrait, ImageableTrait, StorageTrait;

    protected $casts = [
        'location' => 'array'
    ];

    protected $hidden = [
        'ministry_id',
        'created_at',
        'updated_at',
    ];

    function guests()
    {
        return $this->hasMany(Guest::class);
    }

    function getNameAttribute($val)
    {
        return ucwords($val);
    }

    function getDescriptionAttribute($val)
    {
        return ucfirst($val);
    }

    function scopePublished($query)
    {
        if (!config('faithgen-sdk.source'))
            return $query->wherePublished(true);
        else return $query;
    }

    function getPublishedAttribute($val)
    {
        return (bool) $val;
    }

    function filesDir()
    {
        return 'events';
    }

    function getFileName()
    {
        return $this->image->name;
    }

    function getImageDimensions()
    {
        return [0, 50];
    }

    function getAvatarAttribute()
    {
        if (!$this->image()->exists()) return null;
        else {
            return [
                '_50' => SDK::getAsset('storage/events/50-50/' . $this->image->name),
                'original' => SDK::getAsset('storage/events/original/' . $this->image->name),
            ];
        }
    }
}
