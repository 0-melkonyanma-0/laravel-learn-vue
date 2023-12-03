<?php

declare(strict_types=1);

namespace App\Http\Requests\Settlements;

use Illuminate\Foundation\Http\FormRequest;

class CitiesByRegionRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user();
    }

    public function rules(): array
    {
        return [
            'excel_file' => ['required', 'mimes:xlsx,xls']
        ];
    }
}
