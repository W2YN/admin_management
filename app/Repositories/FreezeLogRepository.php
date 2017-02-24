<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/10
 * Time: 16:02
 */

namespace App\Repositories;


use App\Facades\HelpFacades;

class FreezeLogRepository extends CommonRepository
{
    public static $accessor = 'freezelogrepository';

    /**
     *
     * @return FreezeLogRepository
     */
    public static function getInstance()
    {
        return HelpFacades::getFacadeRootByAccessor( self::$accessor );
    }
    
    public function paginateWhere($where, $limit, $columns = ['*'])
    {
        $database = config('ourplus.rbcx-database');
        //$columns = ['freeze_log.*','order.car_owner','order.license_plate'];
        //var_dump($where);
        foreach( $where as $key=>$item ){
            if( $item[0] == 'datetime'){
                $where[$key][0] = 'freeze_log.datetime';
            }
        }
        $this->model = $this->model->leftJoin($database.'.order', 'order.id', '=', 'freeze_log.order_id');
        $this->model = $this->model->orderBy('freeze_log.datetime','desc');
        return parent::paginateWhere($where, $limit, $columns);
    }
}