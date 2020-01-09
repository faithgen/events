<?php

namespace Innoflash\Events\Http\Requests;

use FaithGen\SDK\Helpers\Helper;
use Illuminate\Foundation\Http\FormRequest;
use Innoflash\Events\Services\EventsService;
use Illuminate\Auth\Access\AuthorizationException;

class TogglePublishRequest extends FormRequest
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
            'published' => 'required|boolean'
        ];
    }

    function failedAuthorization()
    {
        throw new AuthorizationException('You are not allowed to update this event');
    }
}
