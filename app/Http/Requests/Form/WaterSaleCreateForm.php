<?php

namespace App\Http\Requests\Form;

use App\Http\Requests\Request;

class WaterSaleCreateForm extends Request
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
        //echo 'required|unique:'.env('DB_DATABASE_WATER_PURIFIER', 'forge').'.sales';exit;
        return [
            'name'                  => 'required|unique:mysql_water_purifier.sales',
        ];
    }

    public function messages()
    {
        return [
            'name.required'                  => '业务员不能为空',
            'name.unique'                    => '业务员已存在',
        ];
    }
}
