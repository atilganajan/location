<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateLocationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
           'name' => 'required|max:255',
           'latitude' => 'required|numeric|between:-90,90',
           'longitude' => 'required|numeric|between:-180,180',
           'marker_color' => 'required|regex:/^[0-9A-Fa-f]{6}$/i',
        ];
    }

    public function messages()
    {
        return [
            'marker_color.regex' => 'Color must be in hexedecimal color code format.',
        ];
    }

}
