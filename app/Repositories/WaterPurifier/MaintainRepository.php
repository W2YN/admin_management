<?php

namespace App\Repositories\WaterPurifier;


use App\Facades\HelpFacades;
use App\Models\Water\Device;
use App\Repositories\CommonRepository;

class MaintainRepository extends CommonRepository
{
    public static $accessor = 'maintain_repository';

    /**
     *
     * @return self
     */
    public static function getInstance()
    {
        return HelpFacades::getFacadeRootByAccessor( self::$accessor );
    }

    public function createMaintain( Device $device ,$install_time)
    {
        $interval = config('waterPurifier.'.env('APP_ENV').'.maintain.interval');
        $amount = config('waterPurifier.'.env('APP_ENV').'.maintain.amount');


        for( $i=0; $i<$amount; $i++ ){
            $datetime = date( 'Y-m-d H:i:s', strtotime($install_time) + ( ($i + 1) * $interval ) );
            $maintain = [
                'water_purifier_id' => $device->water_purifier_id,
                'device_id' => $device->id,
                'datetime' => $datetime,
                'is_complete' => 0,
            ];
            $this->create( $maintain );
        }
    }

    /**
     * 现在有裤子，但万不可脱的
     * @param $where
     * @param $limit
     * @param array $columns
     */
    public function specificPaginateWhere($where, $limit, $columns=["*"])
    {
        $model = $this->model;
        $columns = [
            "maintains.id as maintainId",
            'maintains.water_purifier_id as id', //真是骗人啊
            'maintains.device_id',
            'maintains.datetime',
            'maintains.is_complete',
            'maintains.created_at',
            'maintains.updated_at',
            'water_purifier.num'
        ];
        $model = $model->leftJoin('water_purifier', 'water_purifier.id', '=', 'maintains.water_purifier_id');
        $this->model = $model;
        return parent::paginateWhere($where, $limit, $columns);
    }

}
