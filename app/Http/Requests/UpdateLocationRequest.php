<?php

namespace App\Http\Requests;

use App\Traits\LocationValidationTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLocationRequest extends FormRequest
{
    use LocationValidationTrait;

    public function rules(): array
    {
        return [
            'location_id' =>'required',
            'name' => 'required|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'marker_color' => ['required', 'regex:/^#[a-fA-F0-9]{3}(?:[a-fA-F0-9]{3})?$/'],
        ];
    }

    public function messages()
    {
        return [
            'marker_color.regex' => 'Color must be in hexedecimal color code format.',
        ];
    }


    protected function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $this->toleranceValidation($validator);
        });
    }

    protected function toleranceValidation($validator)
    {

        $error = $this->checkTolerance($this, 'latitude', 'longitude', 'name');

        if ($error !== null) {
            if ($error === "Unexpected error.") {
                abort(500,$error);
            }
            $validator->errors()->add('custom_field', $error);
        }

    }


}
