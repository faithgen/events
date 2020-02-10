<?php

namespace Innoflash\Events\Http\Requests;

use FaithGen\SDK\Helpers\Helper;
use Illuminate\Foundation\Http\FormRequest;
use Innoflash\Events\Services\EventsService;
use Illuminate\Auth\Access\AuthorizationException;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(EventsService $eventsService)
    {
        return $this->user()->can('event.update', $eventsService->getEvent());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'event_id' => Helper::$idValidation,
            'name' => 'required|string',
            'description' => 'required|string',
            'location' => 'required|array',
            'start' => 'required|date_format:Y-m-d H:i',
            'end' => 'required|date_format:Y-m-d H:i',
            'published' => 'required|boolean',
            'url' => 'url',
            'video_url' => 'url',
        ];
    }

    function failedAuthorization()
    {
        throw new AuthorizationException('You are not allowed to update this event');
    }
}
