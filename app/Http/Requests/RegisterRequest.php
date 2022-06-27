<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
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
            'username' => 'required|max:50|min:5',
            'full_name' => 'required|max:50|min:5',
            'email' => ['required',
                Rule::unique('users'),
                'email','max:100'
            ],
            'image' => 'mimes:jpeg,jpg,png,gif|required|max:10000',
            'password' => 'required',
            'repassword' => 'required_with:password|same:password',
            'birthday' => 'date|required',
            'phone_number' => 'required|size:10',
            'gender' => 'required',
            'permission' => 'required',
        ];
    }
}
