<?php

namespace App\Http\Requests\API\User;

use App\Rules\OldPassword;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
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
            'old_password' => ['required', 'min:8', new OldPassword()],
            'password' => ['required', 'confirmed', 'min:8'], // Add 'different:old_password' if you Want New Password Different from old one
        ];
    }
}
