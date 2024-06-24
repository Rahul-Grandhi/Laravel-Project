<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'resource_type' => 'required|string|in:customer,transporter',
            'resource_id' => 'nullable|integer',
        ];
    }
    

    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'phone.required' => 'The phone field is required.',
            'resource_type.required' => 'The resource type field is required.',
            'resource_type.in' => 'The selected resource type is invalid.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'success' => false,
            'response_code' => 422,
            'message' => 'Validation error',
            'errors' => $validator->errors(),
        ], 422);

        throw new HttpResponseException($response);
    }
}
