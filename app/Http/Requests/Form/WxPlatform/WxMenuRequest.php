<?php

namespace App\Http\Requests\Form\WxPlatform;

use App\Http\Requests\Request;

class WxMenuRequest extends Request
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
            'url' => 'required',
            'level_id' => 'required'
            //
        ];
    }

    public function messages()
    {
        return [
            'url.regex' => '链接格式不正确,正确格式为http://www.***.com或者http://www.***.cn',
            'name.required' => '菜单名称未填',
            'url.required' => '菜单链接未填',
        ];
    }
}
