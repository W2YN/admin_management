<?php

namespace App\Http\Requests\Form\Contract;

use App\Http\Requests\Request;

class ContractCreateUpdate extends Request
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
        //echo 'required|unique:contracts,number,' . $this->get('number');exit;
        //echo 'required|unique:'.env('DB_DATABASE_WATER_PURIFIER', 'forge').'.sales';exit;
        return [
            'name'                  => 'required',
            'id_number' => 'sometimes|idNumber',
            //'mobile'                  => ['required','regex:/^13\d{9}$|^14\d{9}$|^15\d{9}$|^17\d{9}$|^18\d{9}$/'],
            'mobile'                  => ['required'],
            'number'                  => 'required|unique:contracts,number,' . $this->route('contract') . ',id,deleted_at,NULL',
            'amount'                  => 'required|numeric',
            'count'                  => 'required|numeric',
            'interest'                  => 'required',
            'buy_date'                  => 'required|date|before:expiry_date',
            'source'                  => 'required',
            'expiry_date'                  => 'required|date|after:buy_date',
            'bank_card'                  => 'required|bankCard',
            'bank_name'                  => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required'                  => '名字不能为空',
            'id_number.id_number' => '身份证号码格式不正确',
            'mobile.required'                    => '手机号码不能为空',
            'mobile.regex'                    => '手机号码格式不正确',
            'number.required'                    => '合同编号不能为空',
            'number.unique'                    => '合同编号不能重复',
            'amount.required'                    => '金额不能为空',
            'amount.numeric'                    => '金额必须为数值',
            'count.required'                    => '期数不能为空',
            'count.numeric'                    => '期数必须为数值',
            'interest.required'                    => '利息不能为空',
            'buy_date.required'                    => '购买日期不能为空',
            'buy_date.date'                    => '购买日期格式不正确',
            'buy_date.before'                    => '购买日期必须早于到期日期',
            'source.required'                    => '来源不能为空',
            'expiry_date.required'                    => '到期日期不能为空',
            'expiry_date.date'                    => '到期日期格式不正确',
            'expiry_date.after'                    => '到期日期必须晚于购买日期',
            'bank_card.required'                    => '银行账户不能为空',
            'bank_card.bank_card'               => '银行卡号格式不正确',
            'bank_name.required'                    => '银行名称不能为空',
        ];
    }
}
