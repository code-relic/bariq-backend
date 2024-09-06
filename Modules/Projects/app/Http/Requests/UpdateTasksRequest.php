<?php

namespace Modules\Projects\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTasksRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1200',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            // 'lists_id' => 'required|exists:lists,id',
            // 'assets' => 'nullable|array',
            'docs' => 'nullable|string|max:2000',
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
