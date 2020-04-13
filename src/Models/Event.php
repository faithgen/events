<?php

namespace Innoflash\Events\Models;

use FaithGen\SDK\Models\UuidModel;
use FaithGen\SDK\SDK;
use FaithGen\SDK\Traits\Relationships\Belongs\BelongsToMinistryTrait;
use FaithGen\SDK\Traits\Relationships\Morphs\CommentableTrait;
use FaithGen\SDK\Traits\Relationships\Morphs\ImageableTrait;
use FaithGen\SDK\Traits\StorageTrait;

class Event extends UuidModel
{
    use BelongsToMinistryTrait, CommentableTrait, ImageableTrait, StorageTrait;

    protected $table = 'fg_events';
    protected $casts = [
        'location' => 'array',
    ];

    protected $hidden = [
        'ministry_id',
        'created_at',
        'updated_at',
    ];

    public function guests()
    {
        return $this->hasMany(Guest::class);
    }

    public function getNameAttribute($val)
    {
        return ucwords($val);
    }

    public function getDescriptionAttribute($val)
    {
        return ucfirst($val);
    }

    public function scopePublished($query)
    {
        if (! config('faithgen-sdk.source')) {
            return $query->wherePublished(true);
        } else {
            return $query;
        }
    }

    public function getPublishedAttribute($val)
    {
        return (bool) $val;
    }

    public function filesDir()
    {
        return 'events';
    }

    public function getFileName()
    {
        return $this->image->name;
    }

    public function getImageDimensions()
    {
        return [0, 50];
    }

    public function getAvatarAttribute()
    {
        if (! $this->image()->exists()) {
            return;
        } else {
            return [
                '_50' => SDK::getAsset('storage/events/50-50/'.$this->image->name),
                'original' => SDK::getAsset('storage/events/original/'.$this->image->name),
            ];
        }
    }
}
