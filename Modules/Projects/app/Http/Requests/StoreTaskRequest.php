<?php

namespace Modules\Projects\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'docs' => 'nullable|file',
            'lists_id' => 'nullable|integer',
        ];
    }

    /**
     * Custom validation error message.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'Title is required.',
            'description.max' => 'Description should not exceed 1000 characters.',
            'docs.file' => 'Documentation must be a file.',
        ];
    }
}
