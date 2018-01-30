<?php

namespace App\Http\Requests;


class InstitutionRequest extends Request
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
            'tel'=>'required',
            'address'=>'required',
            'jgmc'=>'required'
        ];
    }

    public function messages()
    {
        return [
            'tel.required'=>'请输入联系电话',
            'address.required' => '请输入机构地址',
            'jgmc.required' => '请输入单位名称'
        ];
    }
}
