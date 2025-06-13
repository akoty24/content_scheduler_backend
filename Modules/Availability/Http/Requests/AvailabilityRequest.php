<?php

namespace Modules\Availability\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class AvailabilityRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
      public function rules(): array
    {
        return [
            'availabilities' => 'required|array',
        'availabilities.*.day_of_week' => 'required|in:Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday',
        'availabilities.*.start_time' => 'required|date_format:H:i',
        'availabilities.*.end_time' => 'required|date_format:H:i|after:availabilities.*.start_time',
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

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
