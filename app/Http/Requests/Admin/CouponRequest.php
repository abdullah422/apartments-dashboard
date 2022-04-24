<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
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
            'title' => 'required',
            'category_id' => 'required',
            'brand_id' => 'required',
            'des' => 'required',
            'code' => 'max:10',
            'url' => 'nullable'
        ];


        if (in_array($this->method(), ['PUT', 'PATCH'])) {

            $coupon = $this->route()->parameter('coupon');

            $rules['title'] = 'required';
            $rules['category_id'] = 'required';
            $rules['brand_id'] = 'required';
            $rules['des'] = 'required';
            $rules['code'] = 'max:10';
            $rules['url'] = 'nullable';
        }//end of if

        return $rules;


    }//end of rules


    public function messages(): array
    {
        return [
            'brand_id.required' => 'you must select brand.',
            'category_id.required' => 'you must select category.',

        ];
    }
}//end of request
