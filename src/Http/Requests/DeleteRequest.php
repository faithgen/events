<?php

namespace Innoflash\Events\Http\Requests;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Innoflash\Events\Services\EventsService;

class DeleteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(EventsService $eventsService)
    {
        dd($eventsService->getEvent());
        return $eventsService->getEvent()
            && $this->user()->can('delete', $eventsService->getEvent());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }

    public function failedAuthorization()
    {
        throw new AuthorizationException('You are not allowed to delete this event');
    }
}
