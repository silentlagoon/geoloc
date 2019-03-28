<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GenerateGeolocation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'address_col' => 'required|string',
            'lat_output_col' => 'required|string',
            'long_output_col' => 'required|string',
            'row_start_index' => 'required|numeric',
        ];
    }
}
