<?php

namespace App\Http\Requests;


class UserRequest extends Request
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
            'sjhm'=>'required',
            'yhxm'=>'required',
            //'password_confirmation'=>'required',
            'zjlx'=>'required',
            'zjhm'=>'required',
        ];
    }

    public function messages()
    {
        return [
            'sjhm.required'=>'请输入手机号码',
            'yhxm.required' => '请输入姓名',
            //'password.required' => '请输密码',
            'zjlx.required'=>'请选择证书类型',
            'zjhm.required'=>'请选择证书号码',
        ];
    }
}
