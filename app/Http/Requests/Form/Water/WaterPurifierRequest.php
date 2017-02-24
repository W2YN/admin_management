<?php

namespace App\Http\Requests\Form\Water;

use App\Http\Requests\Request;

class WaterPurifierRequest extends Request
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
//            'url' => array('regex:/(http?|ftp?):\/\/(www)\.([^\.\/]+)\.()(\/[\w-\.\/\?\%\&\=]*)?/i'),
            'name' => 'required',
            'mobile' => 'required',

            //
        ];
    }

    public function messages()
    {
        return [

            'name.required' => '申请人姓名未填',
            'mobile.required' => '联系方式未填',
        ];
    }
}
