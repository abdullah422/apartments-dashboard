<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
            'role_id' => 'required',
        ];

        if (in_array($this->method(), ['PUT', 'PATCH'])) {

            $admin = $this->route()->parameter('admin');

            $rules['email'] = 'nullable|email|unique:users,email,' . $admin->id;
            $rules['phone'] = 'required|max:11|min:11|unique:users,phone,' . $admin->id;
            $rules['password'] = '';

        }//end of if

        return $rules;

    }//end of rules

    protected function prepareForValidation()
    {
        return $this->merge([
            'type' => 'admin'
        ]);

    }//end of prepare for validation

}//end of request
