<?php

namespace App\Http\Requests\API\User;

use App\Rules\SaudiMobileNumber;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users')->ignore(auth()->id())],
            'mobile' => ['required', 'regex:/^[0-9]+$/', 'min:9',new SaudiMobileNumber(), Rule::unique('users')->ignore(auth()->id())],
        ];
    }
}
