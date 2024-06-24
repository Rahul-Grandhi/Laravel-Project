<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreTripRequest extends FormRequest
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
            'customer_id'=>'required|integer|exists:customer,id',
            'transporter_id'=>'required|integer|exists:transporter,id',
            'source'=>'required|string|max:255',
            'destination'=>'required|string|max:255',
            'amount'=>'required|numeric|min:0',
            'status'=>'required|string'
        ];
    }

    public function messages()
    {
        return [
            'customer_id.required' => 'Customer ID is required',
            'customer_id.integer' => 'Customer ID must be an integer',
            'customer_id.exists' => 'Customer ID must exist in customers table',
            'transporter_id.required' => 'Transporter ID is required',
            'transporter_id.integer' => 'Transporter ID must be an integer',
            'transporter_id.exists' => 'Transporter ID must exist in transporters table',
            'source.required' => 'Source is required',
            'destination.required' => 'Destination is required',
            'amount.required' => 'Amount is required',
            'amount.numeric' => 'Amount must be a number',
            'status.required' => 'Status is required',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'message' => 'Validation error',
            'errors' => $validator->errors(),
        ], 422);

        throw new HttpResponseException($response);
    }
}
