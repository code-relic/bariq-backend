<?php

namespace Modules\Teams\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AcceptTeamInviteRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'invite_id' => 'required|exists:team_invite,id',
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
