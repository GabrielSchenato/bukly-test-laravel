<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHotelRequest extends FormRequest
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
            'id' => [
                'required'
            ],
            'name' => [
                'required',
                'min:3',
                'max:255'
            ],
            'address' => [
                'required',
                'min:3',
                'max:255'
            ],
            'city' => [
                'required',
                'min:3',
                'max:255'
            ],
            'state' => [
                'required',
                'min:2',
                'max:255'
            ],
            'zip_code' => [
                'required',
                'min:3',
                'max:255'
            ],
            'website' => [
                'nullable',
                'min:3',
                'max:255'
            ],
        ];
    }
}
