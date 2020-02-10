<?php

namespace Innoflash\Events\Models;

use Illuminate\Support\Str;
use FaithGen\SDK\Models\UuidModel;
use Illuminate\Database\Eloquent\Model;

class Guest extends UuidModel
{
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
}
