<?php

declare(strict_types=1);

namespace App\Http\Requests\User;

use App\Enums\SexType;
use App\Enums\StatusType;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserUpdateRequest extends FormRequest
{
    public function authorize(): ?Authenticatable
    {
        return auth()->user();
    }

    public function rules(): array
    {
        return [
            'name'              => ['required', 'string', 'bail', 'min:2', 'max:255'],
            'department_id'     => ['required', 'bail', 'numeric', Rule::exists('departments', 'id')],
            'job_title_id'      => ['required', 'bail', 'numeric', Rule::exists('job_titles', 'id')],
            'email'             => ['required', 'email:rfc,dns', 'bail', Rule::unique('users', 'email')->ignore($this->id)],
            'password'          => ['nullable', 'string', 'confirmed', 'bail', Password::defaults()],
            'sex'               => ['required', new EnumValue(SexType::class)],
            'status'            => ['required', new EnumValue(StatusType::class)],
            'role'              => ['required', 'bail', 'numeric', Rule::exists('roles', 'id')],
        ];
    }
}
