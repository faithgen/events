<?php

namespace Innoflash\Events\Http\Requests;

use FaithGen\SDK\Helpers\Helper;
use FaithGen\SDK\Models\Ministry;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Innoflash\Events\Services\EventsService;

class CommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(EventsService $eventsService)
    {
        if (auth()->user() instanceof Ministry) {
            return $this->user()->can('view', $eventsService->getEvent());
        }

        return true;
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
            'comment' => 'required',
        ];
    }

    public function failedAuthorization()
    {
        throw new AuthorizationException('You do not have access to this event');
    }
}
