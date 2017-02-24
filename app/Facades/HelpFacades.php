<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/8
 * Time: 13:29
 */

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class HelpFacades extends Facade
{
    public static function getFacadeRootByAccessor($accessor)
    {
        return static::resolveFacadeInstance($accessor);
    }
}