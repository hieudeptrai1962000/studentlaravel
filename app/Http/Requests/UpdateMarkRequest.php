<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMarkRequest extends FormRequest
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
            'subject_id.*' => 'required|exists:subjects,id',
            'mark.*' => 'required|numeric|between:0,10',
        ];
    }
    public function messages()
    {
        return [
            'subject_id.*.exists' => 'Vui lòng nhập đúng yêu cầu và không chỉnh sửa gì cả',
            'mark.*.required' => 'Không được để trống',
            'mark.*.between' => 'Vui lòng nhập điểm khoảng từ 1 đến 10',
        ];
    }
}
