<?php

namespace Innoflash\Events\Http\Requests;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Innoflash\Events\Services\EventsService;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(EventsService $eventsService)
    {
        return $eventsService->getEvent()
            && $this->user()->can('update', $eventsService->getEvent());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'        => 'required|string',
            'description' => 'required|string',
            'location'    => 'required|array',
            'start'       => 'required|date_format:Y-m-d H:i',
            'end'         => 'required|date_format:Y-m-d H:i',
            'published'   => 'required|boolean',
            'url'         => 'url',
            'video_url'   => 'url',
            'banner'      => 'base64image',
        ];
    }

    public function failedAuthorization()
    {
        throw new AuthorizationException('You are not allowed to update this event');
    }
}
