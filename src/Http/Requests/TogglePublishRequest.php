<?php

namespace Innoflash\Events\Http\Requests;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Innoflash\Events\Services\EventsService;

class TogglePublishRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @param  \Innoflash\Events\Services\EventsService  $eventsService
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
            'published' => 'required|boolean',
        ];
    }

    public function failedAuthorization()
    {
        throw new AuthorizationException('You are not allowed to update this event');
    }
}
