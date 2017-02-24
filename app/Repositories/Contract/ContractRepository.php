<?php

namespace App\Repositories\Contract;


use App\Facades\HelpFacades;
use App\Models\Water\Purifier as WaterPurifier;
use App\Repositories\CommonRepository;
use DB;

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

    public function countOptions()
    {
        $countOptions = [];
        for( $i=1; $i<=24; $i++ ){
            $countOptions[$i] = "{$i}期";
        }
        return $countOptions;
    }

    /**
     * 筛选条件
     * @param array $contracts  本金筛选条件
     * @param array $installment 利息筛选条件
     */
    public function pureGetByWhere($where)
    {
        $query = "select contracts.*,
        contract_installments.money,
        count(contract_installments.money) as _count,
        sum(contract_installments.money) as _money
        from contracts
        LEFT JOIN contract_installments on contracts.id = contract_installments.contract_id
        where contract_installments.type=0";//" and contract_installments.status=1
        if($where['status']!='NULL'){
            $query .= " and contract_installments.status=".$where['status'];
        }
        $query .= " and contracts.id in ";
         //and contracts.id in  ";
        //if($where['id']) {
        $installmentQuery = "(select contract_installments.contract_id from contract_installments where";
        if($where['id']) {
            $installmentQuery .= " contract_installments.id=".$where['id']. " and";
        }
        if($where['contract_id']) {
            $installmentQuery .= " contract_installments.contract_id=".$where['contract_id']. " and";
        }
        if($where['opertion_timeMin'] && $where['opertion_timeMax']){
            $installmentQuery .= " contract_installments.opertion_time between '".$where['opertion_timeMin'] ."' and '".$where['opertion_timeMax']. "' and";
        }
        $installmentQuery = rtrim($installmentQuery, ' and');
        $query .= $installmentQuery. ") group by contracts.id";
        return DB::select($query);
        //$result = DB::select($query);
        //return $result->toArray();
    }
}
