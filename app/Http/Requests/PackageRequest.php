<?php

namespace App\Http\Requests;


class PackageRequest extends Request
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
            'tcmc'=>'required'
        ];
    }

    public function messages()
    {
        return [
            'tcmc.required'=>'请选择套餐名称',
        ];
    }
}
