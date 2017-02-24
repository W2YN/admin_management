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

class ContractRepository extends CommonRepository
{
    public static $accessor = 'contract_repository';

    /**
     *
     * @return ContractRepository
     */
    public static function getInstance()
    {
        return HelpFacades::getFacadeRootByAccessor( self::$accessor );
    }

    /**
     * 获取合同列表
     */
    public function getContractList($where, $page_limit)
    {
    	$this->model = $this->model->leftJoin('users', 'financial_contract.financial_user_id', '=', 'users.id')
    	                           ->leftJoin('financial_express as e', 'financial_contract.express_id', '=', 'e.id')
    	                           ->select(\DB::raw('financial_contract.*,users.name,e.number,e.send_time'));
    	
    	return $this->paginateWhere($where, $page_limit);
    }
    


    
}