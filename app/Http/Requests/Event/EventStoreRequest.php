<?php

declare(strict_types=1);

namespace App\Http\Requests\Event;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Http\FormRequest;
use LVR\Colour\Hex;

class EventStoreRequest extends FormRequest
{
    public function authorize(): ?Authenticatable
    {
        return auth()->user();
    }

    public function rules(): array
    {
        return [
            'name'         => ['required', 'string', 'bail', 'min:3', 'max:255'],
            'description'   => ['nullable', 'string', 'bail', 'min:0', 'max:4096'],
            'start'         => ['required', 'date'],
            'end'           => ['required', 'date', 'after:start'],
            'color'         => ['required'],
            'user_id'       => ['required', 'integer','bail', 'exists:users,id'],
        ];
    }
}
