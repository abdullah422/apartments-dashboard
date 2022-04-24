<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class OwnerRequest extends FormRequest
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
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'type' => 'required',
        ];

        if (in_array($this->method(), ['PUT', 'PATCH'])) {

            $owner = $this->route()->parameter('owner');

            $rules['email'] = 'required|email|unique:users,id,' . $owner->id;
            $rules['password'] = '';

        }//end of if

        return $rules;

    }//end of rules

    protected function prepareForValidation()
    {
        return $this->merge([
            'type' => 'owner',
        ]);

    }//end of prepare for validation

}//end of request
