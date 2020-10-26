<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Gbook extends FormRequest
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
            //
            'username' => 'required|max:50',
            'content' => 'required|max:255'
        ];
    }
    public function messages()
    {
        return [
            'username.required' => '用户名不能为空',
            'content.required'  => '留言内容不能为空',
        ];
    }
}
