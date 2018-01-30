<?php

namespace App\Http\Requests;


class SmsRequest extends Request
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
            'dxbh'=>'required',
            'mbnr'=>'required'
        ];
    }

    public function messages()
    {
        return [
            'desc.required'=>'请输入简单描述',
            'dxbh.required' => '请输入短信编号',
            'mbnr.required' => '请输入短信模板'
        ];
    }
}
