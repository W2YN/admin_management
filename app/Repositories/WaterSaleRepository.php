<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/16
 * Time: 13:39
 */

namespace App\Repositories;


use App\Facades\HelpFacades;

class WaterSaleRepository extends CommonRepository
{
    public static $accessor = 'water_sale_repository';

    /**
     *
     * @return WaterSaleRepository
     */
    public static function getInstance()
    {
        return HelpFacades::getFacadeRootByAccessor( self::$accessor );
    }

    public function createCode( $id ){
        //最多999个，超了再说，我想不会超吧。
        $code = (1000+$id).'';
        return $code;
    }
}