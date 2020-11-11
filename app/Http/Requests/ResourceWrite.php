<?php

namespace App\Http\Requests;

use App\Models\Resource;
use Illuminate\Foundation\Http\FormRequest;

class ResourceWrite extends FormRequest
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
            'title' => 'required',
            'desc' => 'required',
            'type' => 'required'
        ];
        switch ($this->input('type')) {
            case Resource::VIDEO:
                $rules['ali_id'] = ['required'];
                break;
            case Resource::DOC:
                $rules['content'] = ['required'];
                break;
        }
        return $rules;
    }
    public function attributes()
    {
        return [
            'desc' => '简介',
            'ali_id' => '阿里云视频id'
        ];
    }
}
