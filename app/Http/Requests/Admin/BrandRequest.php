<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
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
            'name' => 'required|unique:brands',
            'image' => 'image'
        ];

        if (in_array($this->method(), ['PUT', 'PATCH'])) {

            $brand = $this->route()->parameter('brand');
            $rules['name'] = 'required|unique:brands,id,' . $brand->id;
            $rules['image'] = 'image';

        }//end of if

        return $rules;

    }//end of rules
}//end of request
