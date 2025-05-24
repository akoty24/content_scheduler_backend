<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class PostRequest extends FormRequest
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
          
           if ($this->isMethod('post')) {
    return [
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'status' => 'nullable|string',
        'scheduled_time' => 'nullable|date|required_if:status,scheduled',
        'platform_ids' => 'required|array',
        'platform_ids.*' => 'exists:platforms,id',
    ];
} else {
    return [
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'status' => 'nullable|string',
        'scheduled_time' => 'nullable|date|required_if:status,scheduled',
        'platform_ids' => 'required|array',
        'platform_ids.*' => 'exists:platforms,id',
    ];
}

    
           
        }
  
        
        protected function failedValidation(Validator $validator)
        {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422));
        }
}
