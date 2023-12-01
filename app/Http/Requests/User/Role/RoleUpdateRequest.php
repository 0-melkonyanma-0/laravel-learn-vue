<?php

declare(strict_types=1);

namespace App\Http\Requests\User\Role;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleUpdateRequest extends FormRequest
{
    public function authorize(): ?Authenticatable
    {
        return auth()->user();
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'bail', 'max:255', Rule::unique('roles', 'name')->ignore($this->id)],
            'permissions' => ['required', 'array', 'min:1'],
            'permissions.*' => ['required', 'numeric', 'bail', 'exists:permissions,id'],
        ];
    }
}
