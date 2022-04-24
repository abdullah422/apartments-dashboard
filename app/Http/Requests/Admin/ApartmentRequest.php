<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ApartmentRequest extends FormRequest
{
    /**
     * Determine if the Category is authorized to make this request.
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
        $rules = [
            'place_id' => 'required',
            'des' => 'nullable',
        ];
        if (in_array($this->method(), ['PUT', 'PATCH'])) {
            $apartment = $this->route()->parameter('apartment');

            $rules['des'] = 'nullable';
        }//end of if

        return $rules;

    }//end of rules


    public function messages(): array
    {
        return [
            'place_id.required' => 'you must select place.',
        ];
    }
}//end of request
