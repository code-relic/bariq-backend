<?php

namespace Modules\Plans\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePlansRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:100',
            'price' => 'sometimes|required|numeric|max:100',
            'id' => 'required|exists:plans,id',
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
