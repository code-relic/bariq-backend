<?php

namespace Modules\Plans\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePlansRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'price' => 'required|numeric',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
