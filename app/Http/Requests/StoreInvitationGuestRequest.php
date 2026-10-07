<?php

namespace App\Http\Requests;

use App\Models\Invitation;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreInvitationGuestRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $phone = preg_replace('/[\\s()\\-]/', '', (string) $this->input('phone', ''));
        $this->merge(['phone' => $phone]);
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $invitation = $this->route('invitation');
        abort_unless($invitation instanceof Invitation, 404);
        $this->user()?->can('update', $invitation) || abort(404);

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:160'],
            'phone' => ['required', 'string', 'max:30', 'regex:/^(\\+?62|0)8[0-9]{7,12}$/'],
            'group_name' => ['nullable', 'string', 'max:100'],
        ];
    }
}
