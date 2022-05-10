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
            'email' => 'nullable|unique:users,email|email',
            'phone' => 'required|unique:users,phone|max:11|min:11',
            'password' => 'required|confirmed',
            'type' => 'required',
        ];

        if (in_array($this->method(), ['PUT', 'PATCH'])) {

            $owner = $this->route()->parameter('owner');

            $rules['email'] = 'nullable|email|unique:users,email,' . $owner->id;
            $rules['phone'] = 'required|max:11|min:11|unique:users,phone,' . $owner->id;

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
