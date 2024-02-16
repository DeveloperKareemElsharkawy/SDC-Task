<?php

namespace App\Http\Requests\API\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'username' => 'required|exists:users,' . $this->username(),
            'password' => ['required', 'string', 'min:8'],
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return string
     */
    public function username(): string
    {
        return (filter_var(request()['username'], FILTER_VALIDATE_EMAIL)) ? 'email' : 'mobile';
    }


    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        $username = $this->username();
        $validationMessages = [
            'username.required' => "حقل $username مطلوب.",
            'password.required' => 'حقل كلمة المرور مطلوب.',
            'password.min' => 'يجب أن تكون كلمة المرور على الأقل ٨ أحرف.',
        ];

        if ($username === 'mobile') {
            $validationMessages['username.exists'] = 'رقم الجوال غير مسجل.';
        } elseif ($username === 'email') {
            $validationMessages['username.exists'] = 'البريد الإلكتروني غير مسجل.';
        }

        return $validationMessages;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'type' => $this->username(),
        ]);
    }
}
