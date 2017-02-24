<?php

namespace App\Http\Requests\Form\Financial;

use App\Http\Requests\Request;

class StoreExpressRequest extends Request
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
            'number' => 'required|regex:/^\w{1,200}$/',
            'send_time' => 'required|date_format:Y-m-d H:i:s',
            'contract_num' => 'required|regex:/^[1-9]\d{0,2}$/',
        ];
    }
    
    public function messages()
    {
        return [
            'number.required' => '快递单号不能为空',
            'number.regex' => '快递单号有误',
            'send_time.required' => '快递发送时间必填',
            'send_time.date_format' => '快递发送时间格式不正确',
            'contract_num.required' => '合同份数必填',
            'contract_num.regex' => '合同份数必须是数字且不能大于1000份',
        ];
    }
}
