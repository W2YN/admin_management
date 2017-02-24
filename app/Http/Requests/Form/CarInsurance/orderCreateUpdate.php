<?php

namespace App\Http\Requests\Form\CarInsurance;

use App\Http\Requests\Request;

class orderCreateUpdate extends Request
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
            'car_owner' => 'required',
            'owner_mobile' => [
                'required',
                'regex:/^13\d{9}$|^14\d{9}$|^15\d{9}$|^17\d{9}$|^18\d{9}$/'],
            'owner_id_number' => 'required|idNumber',
            'owner_address' => 'required',
            'car_model' => 'required',
            'car_engine_num' => 'required',
            'car_vin_code' => 'required',
            'car_register_date' => 'required|date',
            'car_certificate_date' => 'required|date',
            'policy_start_date' => 'required|date|before:policy_end_date',
            'policy_end_date' => 'required|date|after:policy_start_date',
        ];
    }

    public function messages()
    {
        return [
            'car_owner.required' => '车主姓名不能为空',
            'owner_mobile.required' => '车主手机号码不能为空',
            'owner_mobile.regex' => '车主手机号码格式不正确',
            'owner_id_number.required' => '车主身份证不能为空',
            'owner_id_number.id_number' => '车主身份证格式不正确',
            'owner_address.required' => '详细地址不能为空',
            'car_model.required' => '车辆型号不能为空',
            'car_engine_num.required' => '发动机号码不能为空',
            'car_vin_code.required' => '车辆识别代码不能为空',
            'car_register_date.required' => '注册日期不能为空',
            'car_register_date.date' => '注册日期格式不正确',
            'car_certificate_date.required' => '发证日期不能为空',
            'car_certificate_date.date' => '发证日期格式不正确',
            'policy_start_date.required' => '保险期间开始时间不能为空',
            'policy_start_date.date' => '保险期间开始时间格式不正确',
            'policy_start_date.before' => '保险期间开始时间必须早于保险期间结束时间',
            'policy_end_date.required' => '保险期间结束时间不能为空',
            'policy_end_date.date' => '保险期间结束时间格式不正确',
            'policy_end_date.after' => '保险期间结束时间必须晚于保险期间开始时间',
        ];
    }
}
