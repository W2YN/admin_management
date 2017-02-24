<?php

namespace App\Repositories\WaterPurifier;


use App\Facades\HelpFacades;
use App\Models\Water\Purifier as WaterPurifier;
use App\Repositories\CommonRepository;
use App\Repositories\WaterPurifierRepository;

class DeviceRepository extends CommonRepository
{
    public static $accessor = 'device_repository';

    /**
     *
     * @return DeviceRepository
     */
    public static function getInstance()
    {
        return HelpFacades::getFacadeRootByAccessor( self::$accessor );
    }

    function uuid() {
        return WaterPurifierRepository::getInstance()->uuid();
    }

    public function createDevices( WaterPurifier $water_purifier )
    {

        $amount = $water_purifier->amount;
        $install_time = $water_purifier->install_time;
        for( $i=0; $i<$amount; $i++ ){
            $device = array(
                'water_purifier_id' => $water_purifier->id,
                'num' => $this->uuid(),
            );
            $device = $this->create($device);

            MaintainRepository::getInstance()->createMaintain( $device,$install_time );
        }
    }
}
