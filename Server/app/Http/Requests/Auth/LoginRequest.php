<?php

namespace App\Http\Requests\Auth;

use App\Helper\Helper;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'password' => 'required|min:6'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'password.required' => 'The password field is required.',
            'password.confirmed' => 'The password confirmation does not match.',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        $error = $validator->errors();
        throw (new ValidationException($validator, Helper::Error(
            [],
            400,
            $error->getMessages()
        )));
    }
}
