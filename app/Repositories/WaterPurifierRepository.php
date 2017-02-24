<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/16
 * Time: 13:39
 */

namespace App\Repositories;


use App\Facades\HelpFacades;

class WaterPurifierRepository extends CommonRepository
{
    public static $accessor = 'water_purifier_repository';

    /**
     *
     * @return WaterPurifierRepository
     */
    public static function getInstance()
    {
        return HelpFacades::getFacadeRootByAccessor( self::$accessor );
    }

    function uuid()
    {
        if (function_exists('com_create_guid')) {
            return com_create_guid();
        } else {
            mt_srand(( double )microtime() * 10000); //optional for php 4.2.0 and up.随便数播种，4.2.0以后不需要了。
            $charid = strtoupper(md5(uniqid(rand(), true))); //根据当前时间（微秒计）生成唯一id.
            $hyphen = chr(45); // "-"
            $uuid = '' . chr(123) .// "{"
                substr($charid, 0, 8) . $hyphen . substr($charid, 8, 4) . $hyphen . substr($charid, 12, 4) . $hyphen . substr($charid, 16, 4) . $hyphen . substr($charid, 20, 12)
                . chr(125);// "}"
            return $uuid;
        }
    }

    public function paginateWhere($where, $limit, $columns = ['*'])
    {
        $this->model = $this->model->orderBy('created_at', 'desc');
        return parent::paginateWhere($where, $limit, $columns );
    }

    /**
     * getCollectbyWhere是getByWhere的特化版本,专门指定时间用于信息的收集
     */
    public function getCollectByWhere()
    {

    }
	
    /**
     * 删除订单信息
     */
    public function delOrder ($water_purifer_model){
    	\DB::beginTransaction();
    	
    	//删除分期信息
    	$water_purifer_model->installments()->delete();
    	
    	$devices = $water_purifer_model->devices;
    	if(!empty($devices)){
    		//删除设备维护信息
    		foreach($devices as $device){
    			$device->maintains()->delete();
    		}
    	}
    	
    	//删除设备信息
    	$water_purifer_model->devices()->delete();
    	
    	//删除银行卡信息
    	$water_purifer_model->cardInfo()->delete();
    	
    	//删除订单信息
    	$water_purifer_model->delete();
    	
    	return \DB::commit() || \DB::rollBack();
    }
    
}