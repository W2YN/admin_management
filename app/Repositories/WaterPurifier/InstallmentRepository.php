<?php

namespace App\Repositories\WaterPurifier;


use App\Facades\HelpFacades;
use App\Models\Water\Installment;
use App\Models\Water\Purifier as WaterPurifier;
use App\Repositories\CommonRepository;

class InstallmentRepository extends CommonRepository
{
    public static $accessor = 'installment_repository';

    /**
     *
     * @return InstallmentRepository
     */
    public static function getInstance()
    {
        return HelpFacades::getFacadeRootByAccessor( self::$accessor );
    }

    /**
     * @param $water_purifier WaterPurifier
     * @throws \Exception
     */
    public function createInstallments( WaterPurifier $water_purifier )
    {
        $payment = config( 'waterPurifier.payment' );
        if( !isset( $payment[$water_purifier->payment_method]) ){
            throw new \Exception('付款方式异常');
        }
        $payment = $payment[$water_purifier->payment_method];
        $this->clearInstallments($water_purifier->id);
        try{
            //当前时间
            $now = time();
            if( $water_purifier->payment_deposit > 0 ){
                $this->createDeposit( $water_purifier, $now );
            }
            //获取支付间隔时间
            $interval = $payment['interval'];
            $amount = $water_purifier->payment_amount - $water_purifier->payment_deposit;
            for( $i=0; $i<$amount; $i++ ){
                $time = $now + $i * $interval;
                $this->createInstallment( $water_purifier->id, date( 'Y-m-d H:i:s', $time ), $water_purifier->payment_price*$water_purifier->amount, "第".($i+1)."期" );
            }
        }
        catch ( \Exception $e ){
            $this->clearInstallments($water_purifier->id);
            throw new \Exception( $e->getMessage() );
        }
    }

    public function clearInstallments($water_purifier_id){
        $this->model->where('water_purifier_id','=',$water_purifier_id)->delete();
    }

    public function createDeposit( WaterPurifier $water_purifier, $time )
    {
        $this->createInstallment( $water_purifier->id, date( 'Y-m-d H:i:s', $time ), $water_purifier->payment_price*$water_purifier->amount, '押金' );
    }

    public function createInstallment($water_purifier_id,$opertion_time,$money,$remark)
    {
        $data = [];
        $data['water_purifier_id'] = $water_purifier_id;
        $data['opertion_time'] = $opertion_time;
        $data['money'] = $money;
        $data['debit_money'] = 0;
        $data['status'] = 0;
        $data['error_count'] = 0;
        $data['remark'] = $remark;
        $data['card_id'] = 0;
        $this->create( $data );
    }

    /**
     * @param $where
     * @param $limit
     * @param array $columns
     * @return mixed
     */
    public function specificPaginateWhere($where, $limit, $columns=["*"])
    {
        /*
         * @var Installment
         */
        $model = $this->model;

        $columns = [
            'installments.*',
            'water_purifier.name',
            'water_purifier.mobile',
            'water_purifier.num'
        ];
        $model = $model->leftJoin('water_purifier', 'water_purifier.id', '=', 'installments.water_purifier_id');
        $this->model = $model;

        return parent::paginateWhere( $where, $limit, $columns );
    }

    /**
     * 分期扣款失败信息
     * @param array $where
     * @return mixed
     * @throws \App\Traits\Repository\Exception
     */
    public function getForFailDetail(array $where)
    {
        $model = $this->model;

        $columns = [
            'installments.*',
            'water_purifier.name',
            'water_purifier.mobile',
            'water_purifier.num'
        ];
        $model = $model->leftJoin('water_purifier', 'water_purifier.id', '=', 'installments.water_purifier_id');
        $this->model = $model;

        return $this->getByWhere($where, $columns);
    }
}
