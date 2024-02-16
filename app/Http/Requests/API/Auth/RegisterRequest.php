<?php

namespace App\Http\Requests\API\Auth;

use App\Rules\SaudiMobileNumber;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'mobile' => ['required', 'regex:/^[0-9]+$/', 'min:9', 'unique:users,mobile', new SaudiMobileNumber()],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }


}
