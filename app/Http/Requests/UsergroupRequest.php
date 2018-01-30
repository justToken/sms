<?php

namespace App\Http\Requests;


class UsergroupRequest extends Request
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
            'desc'=>'required',
            'name'=>'required'
        ];
    }

    public function messages()
    {
        return [
            'desc.required'=>'请输入简单描述',
            'name.required' => '请输入用户组名'
        ];
    }
}
