<?php

namespace Modules\Teams\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendTeamInviteRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'team_id' => 'required|exists:teams,id',
            'recipient_id' => 'required|exists:users,id',
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
