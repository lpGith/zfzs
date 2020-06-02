<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddArtRequest extends FormRequest
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
            'title' => 'required',
            'desn' => 'required',
            'body' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => '文章标题不能为空',
            'desn.required' => '文章描述不能为空',
            'body.required' => '文章内容不能为空',
        ];
    }
}
