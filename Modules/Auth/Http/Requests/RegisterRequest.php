<?php

namespace Modules\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class RegisterRequest extends FormRequest
{
        public function rules(): array
    {
        return [
            'email'=>'required|email|unique:users',
            'name'=>'required',
            'password'=>'required|min:6',
            'password_confirmation'=>'required|same:password',
            'tenant_name' => 'required|string|max:255',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'errors' => $validator->errors()
        ], 422));
    }
    public function authorize()
    {
        return true;
    }
}
