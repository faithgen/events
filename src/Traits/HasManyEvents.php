<?php


namespace Innoflash\Events\Traits;


use Innoflash\Events\Models\Event;

trait HasManyEvents
{
    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
