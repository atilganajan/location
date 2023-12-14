<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoutingLocationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ];
    }

}
