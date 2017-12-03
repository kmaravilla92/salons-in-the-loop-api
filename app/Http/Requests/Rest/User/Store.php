<?php

namespace App\Http\Requests\Rest\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Http\Requests\RequestBase;

class Store extends RequestBase
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
        return [
            'user.type'          => 'required',
            'user.email'         => 'required|email|unique:users,email', 
            'user.password'      => 'required',
            'user.last_name'     => 'required', 
            'user.first_name'    => 'required', 
            // 'user.phone_number'  => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'user.email.required'   => 'Email is required.', 
            'user.email.email'      => 'Email format is invalid.', 
            'user.email.unique'     => 'Email has already been taken', 
        ];
    }
}
