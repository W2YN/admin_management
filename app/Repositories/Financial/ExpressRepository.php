<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/16
 * Time: 13:39
 */

namespace App\Repositories\Financial;


use App\Facades\HelpFacades;
use App\Repositories\CommonRepository;
use Illuminate\Http\Request;
use DB;
use App\Models\Financial\Contract;

class ExpressRepository extends CommonRepository
{
    public static $accessor = 'express_repository';

    /**
     *
     * @return ExpressRepository
     */
    public static function getInstance()
    {
        return HelpFacades::getFacadeRootByAccessor( self::$accessor );
    }
	
    /**
     * 获取快递列表
     */
	public function getExpressList($where, $page_limit)
	{
		$this->model = $this->model->leftJoin('users', 'financial_express.financial_user_id', '=', 'users.id')
		                           ->leftJoin('financial_contract as c', 'financial_express.id', '=', 'c.express_id')
		                           ->select(\DB::raw('financial_express.*,count(1) as num,users.name'))
		                           ->groupBy('financial_express.id');
		
		return $this->paginateWhere($where, $page_limit);
	}

    /**
     * 保存快递记录和合同信息
     */
	public function saveExrpessAndContract(Request $request)
	{
		$all = $request->all();
		
		DB::connection('mysql_financial')->beginTransaction();
		
		$last = Contract::orderBy('id', 'desc')->first();
		if (empty($last)) {
			$last_sn = 'RX-' . date('YmdHis') . '-000000';
		}else{
			$last_sn = $last->serial_number;
		}
		
		$express_id = $this->model->create([
			'number' => $all['number'],
			'express_company_id' => $all['express_company_id'],
	        'manager_id' => $all['manager_id'],
			'manager_name' => $all['manager_name'],
			'financial_user_id' => $all['financial_user_id'],
			'send_time' => $all['send_time'],
		])->id;
        
		$max_num = $this->formatSN($last_sn, 'second');
		
		$insert_datas = [];
		for ($i=0; $i<$all['contract_num']; $i++) {
			$tmp_num = $max_num + $i + 1;
			$tmp_sn = 'RX-' . date('YmdHis') . '-' . str_pad($tmp_num, 6, '0', STR_PAD_LEFT);
			
			$insert_datas[] = [
	            'serial_number' => $tmp_sn,
	            'type_id' => $all['type_id'],
	            'manager_id' => $all['manager_id'],
	            'manager_name' => $all['manager_name'],
	            'financial_user_id' => $all['financial_user_id'],
	            'express_id' => $express_id,
			];
		}
		
		Contract::insert($insert_datas);

		try {
			DB::connection('mysql_financial')->commit();
			return true;
		} catch (\Exception $e) {
			DB::connection('mysql_financial')->rollBack();
			return false;
		}
	}
	
	/**
	 * 格式化合同编号
	 */
	protected function formatSN($serial_number, $f='first')
	{
		preg_match('/^RX-(\d+)-(\d+)$/', $serial_number, $match);
		
		if (empty($match)) {
			return false;
		}
		
		switch ($f) {
			case 'first':
				return $match[1];
				break;
			case 'second':
				return intval($match[2]);
				break;
			default:
				return false;
				break;
		}
	}

}








