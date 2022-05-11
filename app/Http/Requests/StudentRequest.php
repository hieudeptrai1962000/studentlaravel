<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StudentRequest extends FormRequest
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
            'full_name' => 'required',
            'email' => ['required',
                Rule::unique('students')->ignore($this->student),
            ],
            'birthday' => 'required',
            'gender' => 'required',
            'phone_number' => 'required',
            'faculty_id' => 'required',
        ];
    }
}