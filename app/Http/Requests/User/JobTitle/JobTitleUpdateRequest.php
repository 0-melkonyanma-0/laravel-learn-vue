<?php

declare(strict_types=1);

namespace App\Http\Requests\User\JobTitle;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JobTitleUpdateRequest extends FormRequest
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
                Rule::unique('job_titles', 'title')->ignore($this->id)
            ]
        ];
    }
}
