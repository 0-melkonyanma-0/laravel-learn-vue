<?php

declare(strict_types=1);

namespace App\Http\Requests\User\JobTitle;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Http\FormRequest;

class JobTitleStoreRequest extends FormRequest
{
    public function authorize(): ?Authenticatable
    {
        return auth()->user();
    }

    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'bail',
                'min:4',
                'max:255',
                'unique:departments,title'
            ]
        ];
    }
}
