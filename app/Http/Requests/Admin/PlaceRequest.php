<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PlaceRequest extends FormRequest
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
            'name' => 'required|unique:places',
            'locations'=>'nullable'
        ];

        if (in_array($this->method(), ['PUT', 'PATCH'])) {

            $place = $this->route()->parameter('place');
            $rules['name'] = 'required|unique:places,id,' . $place->id;
            $rules['location']='nullable';
        }//end of if

        return $rules;

    }//end of rules
}//end of request
