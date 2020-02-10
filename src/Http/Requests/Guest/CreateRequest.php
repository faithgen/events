<?php

namespace Innoflash\Events\Http\Requests\Guest;

use FaithGen\SDK\Helpers\Helper;
use Illuminate\Foundation\Http\FormRequest;
use Innoflash\Events\Services\EventsService;
use Illuminate\Auth\Access\AuthorizationException;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(EventsService $eventsService)
    {
        return $eventsService->getEvent() && $this->user()->can('event.view', $eventsService->getEvent());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|min:2|max:15',
            'name' => 'required|string',
            'event_id' => Helper::$idValidation,
            'image' => 'required|base64image'
        ];
    }

    function failedAuthorization()
    {
        throw new AuthorizationException('You are not allowed to transact on this event');
    }
}
