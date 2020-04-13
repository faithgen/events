<?php

namespace Innoflash\Events\Http\Requests;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Innoflash\Events\Models\Event;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;

        return $this->user()->can('create', Event::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'description' => 'required|string',
            'location' => 'array',
            'start' => 'required|date_format:Y-m-d H:i',
            'end' => 'required|date_format:Y-m-d H:i',
            'published' => 'required|boolean',
            'url' => 'url',
            'video_url' => 'url',
            'banner' => 'base64image',
        ];
    }

    protected function failedAuthorization()
    {
        if (strcmp(auth()->user()->account->level, 'Free') === 0) {
            throw new AuthorizationException('You need to upgrade to able to create events');
        }
    }
}
