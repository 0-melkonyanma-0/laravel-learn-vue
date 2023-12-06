<?php

namespace App\Http\Requests\Event;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Http\FormRequest;
use LVR\Colour\Hex;

class EventUpdateRequest extends FormRequest
{
    public function authorize(): ?Authenticatable
    {
        return auth()->user();
    }

    public function rules(): array
    {
        return [
            'name'          => ['required', 'string', 'bail', 'min:3', 'max:255'],
            'description'   => ['nullable', 'string', 'bail', 'min:0', 'max:4096'],
            'start'         => ['required', 'date'],
            'end'           => ['required', 'date', 'after:start'],
            'color'         => ['nullable',],
            'user_id'       => ['nullable', 'integer','bail', 'exists:users,id'],
        ];
    }
}
