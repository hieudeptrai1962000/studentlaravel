<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class SearchRequest extends FormRequest
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
            'min_age' => 'numeric|min:0|max:100|nullable',
            'max_age' => 'numeric|max:100|nullable',
            'min_mark' => 'numeric|max:10|nullable',
            'max_mark' => 'numeric|max:10|nullable',
            'learn_status' => 'in:all,finished,unfinished',
        ];
    }
    public function messages()
    {
        return [
            'subject_id.numeric' => 'Vui lòng nhập đúng yêu cầu và không chỉnh sửa gì cả',
        ];
    }
}
