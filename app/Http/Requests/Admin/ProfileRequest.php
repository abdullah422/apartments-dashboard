<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'phone' => 'required|max:11|min:11|unique:users,phone,' .  auth()->user()->id,
            'email' => 'nullable|email|unique:users,email,' . auth()->user()->id,
            'image' => 'sometimes|nullable|image',
        ];

        return $rules;

    }//end of rules

}//end of request
