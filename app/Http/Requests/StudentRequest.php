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
            'full_name' => 'required|max:50',
            'email' => ['required',
                Rule::unique('students')->ignore($this->id),
                'email','max:100'
            ],
            'birthday' => 'required|date',
            'gender' => 'required|boolean',
            'phone_number' => 'required|numeric|digits_between:9,11',
//            'image' => 'mimes:jpeg,jpg,png,gif|max:10000|nullable'
        ];
    }
    public $validator = null;

    protected function failedValidation($validator)
    {
        $this->validator = $validator;
    }
}
