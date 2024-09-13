<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;


class StoreRegisterUserRequest extends FormRequest
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
            'firstname'=>['required'],
            'lastname'=>['required'],
            'email'=>['required','email','unique:users,email'],
            'password'=>[Password::min(4),'confirmed'],
            'address'=>['nullable'],
            'phone'=>['required']
        ];
    }
}
